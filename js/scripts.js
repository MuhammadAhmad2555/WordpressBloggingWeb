( function( $ ) {
	"use strict";

	//
	// Comments show
	//

	$( document ).on( 'click', '.post-comments-show button', function( e ) {
		$( this ).parent().siblings( '.post-comments' ).css( 'display', 'block' );

		$( this ).parent().remove();
	} );

	( function() {
		var ticking = false;

		var update = function() {

			// Sidebar.
			// -----------------------------------.
			$( '.content-area .site-main' ).each( function() {

				var content = $( this ).find( '.entry-content' );
				var sidebar = $( this ).find( '.entry-sidebar-inner' );

				// Vars offset.
				var offsetTop = 20;
				var offsetBottom = -20;

				// Search elements.
				var elements = [];

				elements.push( '> .alignfull' );
				elements.push( '> .alignwide' );

				var layouts = $( content ).find( elements.join( ',' ) );

				if ( 0 === sidebar.length ) {
					return;
				}
				if ( 0 === layouts.length ) {
					return;
				}

				var disabled = false;

				// Get sidebar values.
				var sidebarTop = $( sidebar ).offset().top;
				var sidebarHeight = $( sidebar ).outerHeight( true );

				for ( let i = 0; i < $( layouts ).length; ++i ) {
					if ( 'none' === $( layouts[ i ] ).css( 'transform' ) ) {
						continue;
					}

					// Get layout values.
					let layoutTop = $( layouts[ i ] ).offset().top;
					let layoutHeight = $( layouts[ i ] ).outerHeight( true );

					// Calc points.
					let pointTop = layoutTop - offsetTop;
					let pointBottom = layoutTop + layoutHeight + offsetBottom;

					// Detect sidebar location.
					if ( sidebarTop + sidebarHeight >= pointTop && sidebarTop <= pointBottom ) {
						disabled = true;
					}
				}

				if ( disabled ) {
					$( sidebar ).css( 'opacity', '0' );
				} else {
					$( sidebar ).css( 'opacity', '1' );
				}
			} );

			// Ticking.
			ticking = false;
		};

		var requestTick = function() {
			if ( !ticking ) {
				window.requestAnimationFrame( update );
				ticking = true;
			}
		};

		var onProcess = function() {
			requestTick();
		};

		$( window ).on( 'scroll', onProcess );
		$( window ).on( 'resize', onProcess );
		$( window ).on( 'image-load', onProcess );
		$( window ).on( 'post-load', onProcess );

	} )();

	/**
	 * Add Class on Input Focus
	 */

	$( '.cs-input-easy-group' ).find( 'input, textarea' ).not( '[type="submit"]' ).focus( function() {
		$( this ).closest( 'p, .cs-field' ).addClass( 'input-focus' );
	} ).blur( function() {
		if ( !$( this ).val() ) {
			$( this ).closest( 'p, .cs-field' ).removeClass( 'input-focus' );
		}
	} );
	/**
	 * AJAX Load More.
	 *
	 * Contains functions for AJAX Load More.
	 */


	/**
	 * Check if Load More is defined by the wp_localize_script
	 */
	if ( typeof csco_ajax_pagination !== 'undefined' ) {

		$( '.post-archive' ).append( '<div class="ajax-navigation"><button class="load-more">' + csco_ajax_pagination.translation.load_more + '</button></div>' );

		var query_data = $.parseJSON( csco_ajax_pagination.query_data ),
			infinite = $.parseJSON( query_data.infinite_load ),
			button = $( '.ajax-navigation .load-more' ),
			page = 2,
			loading = false,
			scrollHandling = {
				allow: infinite,
				reallow: function() {
					scrollHandling.allow = true;
				},
				delay: 400 //(milliseconds) adjust to the highest acceptable value
			};

	}

	/**
	 * Get next posts
	 */
	function csco_ajax_get_posts() {
		loading = true;
		// Set class loading.
		button.addClass( 'loading' );
		var data = {
			action: 'csco_ajax_load_more',
			page: page,
			posts_per_page: csco_ajax_pagination.posts_per_page,
			query_data: csco_ajax_pagination.query_data,
			_ajax_nonce: csco_ajax_pagination.nonce,
		};

		// Request Url.
		var csco_pagination_url;
		if ( 'ajax_restapi' === csco_ajax_pagination.type ) {
			csco_pagination_url = csco_ajax_pagination.rest_url;
		} else {
			csco_pagination_url = csco_ajax_pagination.url;
		}

		// Send Request.
		$.post( csco_pagination_url, data, function( res ) {
			if ( res.success ) {

				// Get the posts.
				var data = $( res.data.content );

				// Check if there're any posts.
				if ( data.length ) {

					var cscoAppendEnd = function() {

						// WP Post Load trigger.
						$( document.body ).trigger( 'post-load' );

						// Reinit Facebook widgets.
						if ( $( '#fb-root' ).length && 'object' === typeof FB ) {
							FB.XFBML.parse();
						}

						// Remove class loading.
						button.removeClass( 'loading' );

						// Increment a page.
						page = page + 1;

						// Set the loading state.
						loading = false;
					};

					// Append new posts to archives.
					if ( $( '.post-archive .archive-main' ).hasClass( 'archive-masonry' ) ) {
						data.imagesLoaded( function() {
							// Append new posts to masonry layout.
							$( '.post-archive .archive-main' ).colcade( 'append', data );

							cscoAppendEnd();
						} );
					} else {
						$( '.post-archive .archive-main' ).append( data );

						cscoAppendEnd();
					}
				}

				// Remove Button on Posts End.
				if ( res.data.posts_end || !data.length ) {

					// Remove Load More button.
					button.remove();
				}

			} else {
				// console.log(res);
			}
		} ).fail( function( xhr, textStatus, e ) {
			// console.log(xhr.responseText);
		} );
	}

	/**
	 * Check if Load More is defined by the wp_localize_script
	 */
	if ( typeof csco_ajax_pagination !== 'undefined' ) {

		// On Scroll Event.
		$( window ).scroll( function() {
			if ( button.length && !loading && scrollHandling.allow ) {
				scrollHandling.allow = false;
				setTimeout( scrollHandling.reallow, scrollHandling.delay );
				var offset = $( button ).offset().top - $( window ).scrollTop();
				if ( 4000 > offset ) {
					csco_ajax_get_posts();
				}
			}
		} );

		// On Click Event.
		$( 'body' ).on( 'click', '.load-more', function() {
			if ( !loading ) {
				csco_ajax_get_posts();
			}
		} );

	}

	/**
	 * AJAX Auto Load Next Post.
	 *
	 * Contains functions for AJAX Auto Load Next Post.
	 */


	/**
	 * Check if Load Nextpost is defined by the wp_localize_script
	 */
	if ( typeof csco_ajax_nextpost !== 'undefined' ) {

		var objNextpost = $( '.post-wrap' ),
			objNextsect = '.cs-nextpost-section',
			currentNTitle = document.title,
			currentNLink = window.location.href,
			loadingNextpost = false,
			scrollNextpost = {
				allow: true,
				reallow: function() {
					scrollNextpost.allow = true;
				},
				delay: 400 //(milliseconds) adjust to the highest acceptable value
			};
	}

	/**
	 * Get next post
	 */
	function csco_ajax_get_nextpost() {
		loadingNextpost = true;

		// Set class loading.
		var data = {
			action: 'csco_ajax_load_nextpost',
			not_in: csco_ajax_nextpost.not_in,
			layout: csco_ajax_nextpost.layout,
			sidebar: csco_ajax_nextpost.sidebar,
			current_user: csco_ajax_nextpost.current_user,
			nonce: csco_ajax_nextpost.nonce,
			next_post: csco_ajax_nextpost.next_post,
		};

		// Request Url.
		var csco_ajax_nextpost_url;
		if ( 'ajax_restapi' === csco_ajax_nextpost.type ) {
			csco_ajax_nextpost_url = csco_ajax_nextpost.rest_url;
		} else {
			csco_ajax_nextpost_url = csco_ajax_nextpost.url;
		}

		// Send Request.
		$.post( csco_ajax_nextpost_url, data, function( res ) {

			csco_ajax_nextpost.next_post = false;

			if ( res.success ) {

				// Get the posts.
				var data = $( res.data.content );

				// Check if there're any posts.
				if ( data.length ) {
					// Set the loading state.
					loadingNextpost = false;

					// Set not_in.
					csco_ajax_nextpost.not_in = res.data.not_in;

					// Set next data.
					csco_ajax_nextpost.next_post = res.data.next_post;

					// Remove loader.
					$( objNextpost ).siblings( '.cs-nextpost-loading' ).remove();

					// Append new post.
					$( objNextpost ).append( data );

					// Reinit facebook.
					if ( $( '#fb-root' ).length && 'object' === typeof FB ) {
						FB.XFBML.parse();
					}

					$( document.body ).trigger( 'post-load' );
				}
			} else {
				// console.log(res);
			}
		} ).fail( function( xhr, textStatus, e ) {
			// console.log(xhr.responseText);
		} );
	}

	/**
	 * Check if Load Nextpost is defined by the wp_localize_script
	 */
	if ( typeof csco_ajax_nextpost !== 'undefined' ) {

		// On Scroll Event.
		$( window ).scroll( function() {
			var scrollTop = $( window ).scrollTop();

			// Init nextpost.
			if ( csco_ajax_nextpost.next_post ) {

				if ( objNextpost.length && !loadingNextpost && scrollNextpost.allow ) {
					scrollNextpost.allow = false;
					setTimeout( scrollNextpost.reallow, scrollNextpost.delay );
					// Calc current offset.
					let offset = objNextpost.offset().top + objNextpost.innerHeight() - scrollTop;
					// Load nextpost.
					if ( 4000 > offset ) {
						$( objNextpost ).after( '<div class="cs-nextpost-loading"></div>' );

						csco_ajax_get_nextpost();
					}
				}
			}

			// Reset browser data link.
			let objFirst = $( objNextsect ).first();

			if ( objFirst.length ) {
				let firstTop = $( objFirst ).offset().top;
				// If there has been a change.
				if ( scrollTop < firstTop && window.location.href !== currentNLink ) {
					document.title = currentNTitle;
					window.history.pushState( null, currentNTitle, currentNLink );
				}
			}

			// Set browser data link.
			$( objNextsect ).each( function( index, elem ) {
				let elemTop = $( elem ).offset().top;
				let elemHeight = $( elem ).innerHeight();

				if ( scrollTop > elemTop && scrollTop < elemTop + elemHeight ) {
					// If there has been a change.
					if ( window.location.href !== $( elem ).data( 'url' ) ) {
						// New title.
						document.title = $( elem ).data( 'title' );
						// New link.
						window.history.pushState( null, $( elem ).data( 'title' ), $( elem ).data( 'url' ) );
						// Google Analytics.
						if ( typeof gtag === 'function' && typeof window.gaData === 'object' ) {

							var trackingId = Object.keys( window.gaData )[ 0 ];
							if ( trackingId ) {
								gtag( 'config', trackingId, {
									'page_title': $( elem ).data( 'title' ),
									'page_location': $( elem ).data( 'url' )
								} );

								gtag( 'event', 'page_view', { 'send_to': trackingId } );
							}
						}
					}
				}
			} );
		} );
	}

	/**
	 * Masonry Widget Area
	 */

	function initMasonrySidebar() {

		/**
		 * Masonry Options
		 */
		var masonrySidebar = $( '.widget-area' ),
			masonrySidebarOptions = {
				columns: '.sidebar',
				items: ' .widget'
			};

		// Set Masonry.
		$( masonrySidebar ).imagesLoaded( function() {
			$( masonrySidebar ).colcade( masonrySidebarOptions );
		} );
	}

	$( document ).ready( function() {
		initMasonrySidebar();
	} );

	/**
	 * Masonry Archive
	 */

	function initMasonry() {

		var masonryArchive = $( '.archive-masonry' ),
			masonryArchiveOptions = {
				columns: '.archive-col',
				items: 'article'
			};

		$( masonryArchive ).imagesLoaded( function() {
			$( masonryArchive ).colcade( masonryArchiveOptions );
		} );
	}

	$( document ).ready( function() {
		initMasonry();
	} );

	/*
	 * Load Mega Menu Posts
	 */
	function cscoLoadMenuPosts( menuItem ) {
		var dataCat = menuItem.children( 'a' ).data( 'cat' ),
			dataType = menuItem.children( 'a' ).data( 'type' ),
			dataNumberposts = menuItem.children( 'a' ).data( 'numberposts' ),
			menuContainer,
			postsContainer;

		// Containers.
		if ( menuItem.hasClass( 'cs-mega-menu-has-category' ) ) {
			menuContainer = menuItem;
			postsContainer = menuContainer.find( '.cs-mm-posts' );
		} else {
			menuContainer = menuItem.closest( '.sub-menu' );
			postsContainer = menuContainer.find( '.cs-mm-posts[data-cat="' + dataCat + '"]' );
		}

		// Set Active.
		menuContainer.find( '.menu-item, .cs-mm-posts' ).removeClass( 'active-item' );
		menuItem.addClass( 'active-item' );

		if ( postsContainer ) {
			postsContainer.addClass( 'active-item' );
		}

		// Check Loading.
		if ( menuItem.hasClass( 'cs-mm-loading' ) || menuItem.hasClass( 'cs-mm-loaded' ) ) {
			return false;
		}

		// Check Category.
		if ( !dataCat || typeof dataCat === 'undefined' ) {
			return false;
		}

		// Check Container.
		if ( !postsContainer || typeof postsContainer === 'undefined' ) {
			return false;
		}

		// Create Data.
		var data = {
			'cat': dataCat,
			'type': dataType,
			'per_page': dataNumberposts
		};

		// Get Results.
		$.ajax( {
			url: csco_mega_menu.rest_url,
			type: 'GET',
			data: data,
			global: false,
			async: true,
			beforeSend: function() {
				menuItem.addClass( 'cs-mm-loading' );
				postsContainer.addClass( 'cs-mm-loading' );
			},
			success: function( res ) {
				if ( res.status && 'success' === res.status ) {

					// Set the loaded state.
					menuItem.addClass( 'cs-mm-loaded' );
					postsContainer.addClass( 'cs-mm-loaded' );

					// Check if there're any posts.
					if ( res.content && res.content.length ) {

						$( res.content ).imagesLoaded( function() {

							// Append Data.
							postsContainer.html( res.content );
						} );
					}
				}
			},
			complete: function() {
				menuItem.removeClass( 'cs-mm-loading' );
				postsContainer.removeClass( 'cs-mm-loading' );
			}
		} );
	}

	/*
	 * Get First Tab
	 */
	function cscoGetFirstTab( container ) {
		var firstTab = false;

		container.find( '.cs-mega-menu-child' ).each( function( index, el ) {
			if ( $( el ).hasClass( 'menu-item-object-category' ) ) {
				firstTab = $( el );
				return false;
			}
			if ( $( el ).hasClass( 'menu-item-object-post_tag' ) ) {
				firstTab = $( el );
				return false;
			}
		} );

		return firstTab;
	}

	/*
	 * Menu on document ready
	 */
	$( document ).ready( function() {

		/*
		 * Get Menu Posts on Hover
		 */
		$( '.navbar-nav .menu-item.cs-mega-menu-has-category, .navbar-nav .menu-item.cs-mega-menu-child' ).on( 'mouseenter', function() {
			cscoLoadMenuPosts( $( this ) );
		} );

		/*
		 * Load First Tab on Mega Menu Hover
		 */
		$( '.navbar-nav .menu-item.cs-mega-menu-has-categories' ).on( 'mouseenter', function() {
			var tab = cscoGetFirstTab( $( this ) );

			if ( tab ) {
				cscoLoadMenuPosts( tab );
			}
		} );
	} );

	/*
	 * Load First Tab on Navbar Ready.
	 */
	$( document, '.navbar-nav' ).ready( function() {
		var tab = false;

		// Autoload First Tab.
		$( '.navbar-nav .menu-item.cs-mega-menu-has-categories' ).each( function( index, el ) {
			tab = cscoGetFirstTab( $( this ) );
			if ( tab ) {
				cscoLoadMenuPosts( tab );
			}
		} );

		// Autoload Category.
		$( '.navbar-nav .menu-item.cs-mega-menu-has-category' ).each( function( index, el ) {
			cscoLoadMenuPosts( $( this ) );
		} );
	} );

	/**
	 * Merge Carousel
	 */

	function initMergeCarousel() {

		$( '.cs-merge-carousel' ).each( function( index, container ) {

			var rtl = $( 'body' ).hasClass( 'rtl' ) ? true : false;

			$( container ).addClass( 'owl-carousel' );

			$( container ).imagesLoaded( function( instance ) {
				$( container ).owlCarousel( {
					navContainer: $( container ).siblings( '.owl-nav' ),
					dotsContainer: $( container ).siblings( '.owl-dots' ),
					rtl: rtl,
					navText: [ '', '' ],
					autoHeight: true,
					margin: 0,
					responsive: {
						0: {
							items: 1,
							merge: false,
							dots: true,
							nav: false,
						},
						1000: {
							items: $( container ).data( 'columns' ),
							merge: true,
							dots: false,
							nav: true,
						},
						1360: {
							items: $( container ).data( 'xl-columns' ) ? $( container ).data( 'xl-columns' ) : $( container ).data( 'columns' ),
							merge: true,
							dots: false,
							nav: true,
						},
						1920: {
							items: $( container ).data( 'full-columns' ) ? $( container ).data( 'full-columns' ) : $( container ).data( 'columns' ),
							merge: true,
							dots: false,
							nav: true,
						}
					},
					onInitialized: function( event ) {
						$( container ).closest( '.cs-merge-init' ).removeClass( 'cs-merge-init' );
					},
				} );
			} );

		} );

	}

	$( document ).ready( function() {
		initMergeCarousel();
		$( document.body ).on( 'post-load', function() {
			initMergeCarousel();
		} );
	} );
	//
	// Responsive Navigation
	//

	$.fn.responsiveNav = function() {
		this.removeClass( 'menu-item-expanded' );
		if ( this.prev().hasClass( 'submenu-visible' ) ) {
			this.prev().removeClass( 'submenu-visible' ).slideUp( 350 );
			this.parent().removeClass( 'menu-item-expanded' );
		} else {
			this.parent().parent().find( '.menu-item .sub-menu' ).removeClass( 'submenu-visible' ).slideUp( 350 );
			this.parent().parent().find( '.menu-item-expanded' ).removeClass( 'menu-item-expanded' );
			this.prev().toggleClass( 'submenu-visible' ).hide().slideToggle( 350 );
			this.parent().toggleClass( 'menu-item-expanded' );
		}
	};

	//
	// Navigation Menu Widget
	//

	$( document ).ready( function( e ) {

		$( '.widget_nav_menu .menu-item-has-children' ).each( function( e ) {

			// Add a caret.
			$( this ).append( '<span></span>' );

			// Fire responsiveNav() when clicking a caret.
			$( '> span', this ).on( 'click', function( e ) {
				e.preventDefault();
				$( this ).responsiveNav();
			} );

			// Fire responsiveNav() when clicking a parent item with # href attribute.
			if ( '#' === $( '> a', this ).attr( 'href' ) ) {
				$( '> a', this ).on( 'click', function( e ) {
					e.preventDefault();
					$( this ).next().next().responsiveNav();
				} );
			}

		} );

	} );

	/*
	 * ----------------------------------------------------------------------------
	 * Navigation
	 */

	var cscoNavigation = {};

	( function() {
		var $this;

		cscoNavigation = {
			sScrollAllow: false,
			sInFirst: true,
			sInterval: 0,
			sPrevious: 0,
			sDirection: 0,

			loadStickyOffset: 0,
			loadAdminBar: false,

			Sticky: $( 'body' ).hasClass( 'navbar-sticky-enabled' ),
			StickyUp: $( 'body' ).hasClass( 'navbar-smart-enabled' ),
			StickyNav: $( '.site-header .navbar-primary' ),
			StickyHeader: $( '.site-header' ),
			StickyOffsetType: 'auto',
			StickyOffset: 0,
			StickyOffsetFull: 0,

			/*
			 * Initialize
			 */
			init: function( e ) {
				$this = cscoNavigation;

				// Init events.
				$this.events( e );
			},

			/*
			 * Events
			 */
			events: function( e ) {
				// DOM Load
				window.addEventListener( 'load', function( e ) {
					$this.stickyInit( e );
					$this.smartLevels( e );
					$this.adaptTablet( e );
				} );
				// Resize
				window.addEventListener( 'resize', function( e ) {
					$this.stickyInit( e );
					$this.smartLevels( e );
					$this.adaptTablet( e );
				} );
				// Scroll
				window.addEventListener( 'scroll', function( e ) {
					window.requestAnimationFrame( $this.stickyScroll );
				} );
			},

			/*
			 * Init nav bar sticky
			 */
			stickyInit: function( e ) {

				if ( !$this.Sticky ) {
					return;
				}

				$this.sScrollAllow = false;

				// Calc sticky offset.
				if ( $this.StickyOffsetType !== 'size' ) {

					var calcbar = 0;
					var wpadminbar = 0;

					if ( $( '#wpadminbar' ).length > 0 ) {
						calcbar = $( '#wpadminbar' ).outerHeight();

						wpadminbar = calcbar;

						if ( 'resize' !== e.type ) {
							$this.loadAdminBar = wpadminbar;
						}

						if ( 'absolute' === $( '#wpadminbar' ).css( 'position' ) ) {
							wpadminbar = 0;

							if ( 'resize' !== e.type ) {
								$this.loadAdminBar = 0;
							}
						}
					}

					// Calc outside header.
					$this.StickyOffsetFull = $this.StickyHeader.outerHeight();

					// Calc on load offset top.
					var elOffset = $this.StickyNav.not( '.sticky-nav' ).offset();

					if ( elOffset && !$this.StickyNav.hasClass( '.sticky-nav' ) ) {

						$this.StickyOffset = elOffset.top;

						$this.loadStickyOffset = elOffset.top;
					} else {
						$this.StickyOffset = $this.loadStickyOffset;
					}

					// Consider the size of the wpadminbar.
					if ( 32 === $this.loadAdminBar ) {
						if ( 46 === calcbar ) {
							$this.StickyOffset = $this.StickyOffset - wpadminbar + 14;
						} else {
							$this.StickyOffset = $this.StickyOffset - wpadminbar;
						}
					} else if ( 46 === $this.loadAdminBar || 0 === $this.loadAdminBar ) {

						if ( 32 === calcbar ) {
							$this.StickyOffset = $this.StickyOffset - wpadminbar - 14;
						} else {
							$this.StickyOffset = $this.StickyOffset - wpadminbar;
						}
					}
				}

				// Nav Height.
				var navHeight = $this.StickyNav.outerHeight();

				// Set the min-height default of the header.
				$this.StickyHeader.data( 'min-height', $this.StickyOffsetFull - navHeight );

				// Document ready.
				if ( 'resize' !== e.type ) {

					// Add nav dummy.
					$this.StickyNav.after( '<div class="navbar-dummy"></div>' );
					$this.StickyHeader.find( '.navbar-dummy' ).height( navHeight );

					// Set type slide.
					if ( $this.StickyUp ) {
						$this.StickyHeader.addClass( 'sticky-type-slide' );
					}
				}

				// Allow.
				$this.sScrollAllow = true;
			},

			/*
			 * Make nav bar sticky
			 */
			stickyScroll: function( e ) {
				if ( !$this.sScrollAllow ) {
					return;
				}

				var scrollCurrent = $( window ).scrollTop();

				if ( $this.StickyUp ) {

					if ( scrollCurrent > $this.StickyOffsetFull ) {
						$this.StickyNav.addClass( 'sticky-nav' );
					}

					if ( scrollCurrent <= $this.StickyOffset ) {
						$this.StickyNav.removeClass( 'sticky-nav' );
					}

					// Set scroll temporary vars.
					if ( scrollCurrent > $this.sPrevious ) {
						$this.sInterval = 0;
						$this.sDirection = 'down';

						$this.StickyNav.addClass( 'sticky-down' ).removeClass( 'sticky-up' );
					} else {
						$this.sInterval += $this.sPrevious - scrollCurrent;
						$this.sDirection = 'up';

						$this.StickyNav.addClass( 'sticky-up' ).removeClass( 'sticky-down' );
					}

					// Сonditions.
					if ( $this.sInterval > 150 && 'up' === $this.sDirection ) {
						$this.StickyNav.addClass( 'sticky-nav-slide-visible' );

						$( document ).trigger( 'sticky-nav-visible' );
					} else {
						$this.StickyNav.removeClass( 'sticky-nav-slide-visible' );

						$( document ).trigger( 'sticky-nav-hide' );
					}

					if ( scrollCurrent > $this.StickyOffsetFull + 150 ) {
						$this.StickyNav.addClass( 'sticky-nav-slide' );
					} else {
						$this.StickyNav.removeClass( 'sticky-nav-slide' );
					}

					// Show onload document.
					if ( $this.sInFirst && scrollCurrent > $this.StickyOffsetFull + 150 ) {
						$this.StickyNav.addClass( ' sticky-nav-slide-visible sticky-up' );
						$this.StickyNav.addClass( 'sticky-nav-slide' );

						$( document ).trigger( 'sticky-nav-visible' );

						$this.sDirection = 'up';
						$this.sInterval = 151;
						$this.sInFirst = false;
					}
				} else {
					// Сonditions.
					if ( scrollCurrent > $this.StickyOffset ) {
						$this.StickyNav.addClass( 'sticky-nav' );

						$( document ).trigger( 'sticky-nav-visible' );
					} else {
						$this.StickyNav.removeClass( 'sticky-nav' );
						$( document ).trigger( 'sticky-nav-hide' );
					}
				}

				$this.sPrevious = scrollCurrent;
			},

			/*
			 * Smart multi-Level menu
			 */
			smartLevels: function( e ) {

				var windowWidth = $( window ).width();

				// Reset Calc.
				$( '.navbar-nav li' ).removeClass( 'cs-mm-level' );
				$( '.navbar-nav li' ).removeClass( 'cs-mm-position-left cs-mm-position-right' );
				$( '.navbar-nav li .sub-menu' ).removeClass( 'cs-mm-position-init' );

				// Set Settings.
				$( '.navbar-nav > li.menu-item' ).not( '.cs-mega-menu' ).each( function( index, parent ) {
					var position = 'cs-mm-position-right';
					var objPrevWidth = 0;

					$( parent ).find( '.sub-menu' ).each( function( index, el ) {

						// Reset child levels.
						$( el ).parent().next( 'li' ).addClass( 'cs-mm-level' );

						if ( $( el ).parent().hasClass( 'cs-mm-level' ) ) {

							$( el ).parent().removeClass( 'cs-mm-level' );

							position = 'cs-mm-position-right';
							objPrevWidth = 0;
						}

						// Find out position items.
						var offset = $( el ).offset();
						var objOffset = offset.left;

						if ( 'cs-mm-position-right' === position && $( el ).outerWidth() + objOffset > windowWidth ) {
							position = 'cs-mm-position-left';
						}

						if ( 'cs-mm-position-left' === position && objOffset - ( $( el ).outerWidth() + objPrevWidth ) < 0 ) {
							position = 'cs-mm-position-right';
						}

						objPrevWidth = $( el ).outerWidth();

						$( el ).addClass( 'cs-mm-position-init' ).parent().addClass( position );
					} );

				} );
			},

			/*
			 * Adapting nav bar for tablet
			 */
			adaptTablet: function( e ) {
				// Click outside.
				$( document ).on( 'touchstart', function( e ) {

					if ( !$( e.target ).closest( '.navbar-nav' ).length ) {
						$( '.navbar-nav .menu-item-has-children' ).removeClass( 'submenu-visible' );
					} else {
						$( e.target ).parents( '.menu-item' ).siblings().find( '.menu-item' ).removeClass( 'submenu-visible' );
						$( e.target ).parents( '.menu-item' ).siblings().closest( '.menu-item' ).removeClass( 'submenu-visible' );
					}
				} );

				$( '.navbar-nav .menu-item-has-children' ).each( function( e ) {

					// Reset class.
					$( this ).removeClass( 'submenu-visible' );

					// Remove expanded.
					$( this ).find( '> a > .expanded' ).remove();

					// Add a caret.
					if ( 'ontouchstart' in document.documentElement ) {
						$( this ).find( '> a' ).append( '<span class="expanded"></span>' );
					}

					// Check touch device.
					$( this ).addClass( 'ontouchstart' in document.documentElement ? 'touch-device' : '' );

					$( '> a .expanded', this ).on( 'touchstart', function( e ) {
						e.preventDefault();

						$( this ).closest( '.menu-item-has-children' ).toggleClass( 'submenu-visible' );
					} );


					if ( '#' === $( '> a', this ).attr( 'href' ) ) {
						$( '> a', this ).on( 'touchstart', function( e ) {
							e.preventDefault();

							if ( !$( e.target ).hasClass( 'expanded' ) ) {
								$( this ).closest( '.menu-item-has-children' ).toggleClass( 'submenu-visible' );
							}
						} );
					}
				} );
			}
		};

	} )();

	// Initialize.
	cscoNavigation.init();

	//
	// Mobile Menu
	//

	$( '.toggle-offcanvas, .site-overlay' ).on( 'click', function( e ) {
		e.preventDefault();
		$( 'body' ).toggleClass( 'offcanvas-active' );
	} );

	/**
	 * Parallax
	 */

	function initParallax() {

		var isIE = /MSIE|Trident/i.test( navigator.userAgent );

		if ( !isIE ) {

			$( '.parallax-enabled .cs-parallax-image' ).jarallax( {
				imgElement: '.cs-parallax-image img'
			} );

			$( '.cs-parallax-video' ).each( function() {
				$( this ).jarallax( {
					imgElement: '.cs-parallax-video img',
					videoSrc: $( this ).attr( 'data-video' ),
					videoStartTime: $( this ).attr( 'data-video-start' ) > 0 ? $( this ).attr( 'data-video-start' ) : '',
					videoEndTime: $( this ).attr( 'data-video-end' ) > 0 ? $( this ).attr( 'data-video-end' ) : '',
				} );
			} );
		}
	}

	$( document ).ready( function() {
		initParallax();
		$( document.body ).on( 'post-load', function() {
			initParallax();
		} );
	} );
	/**
	 * Responsive Embeds
	 */

	( function() {
		/**
		 * Add max-width & max-height to <iframe> elements, depending on their width & height props.
		 */
		function initResponsiveEmbeds() {
			var proportion, parentWidth;

			// Loop iframe elements.
			$( '.entry-content' ).find( 'iframe' ).each( function( index, iframe ) {
				// Don't handle if the parent automatically resizes itself.
				if ( $( iframe ).closest( 'div' ).is( '[data-video-start], [data-video-end]' ) ) {
					return;
				}
				// Only continue if the iframe has a width & height defined.
				if ( iframe.width && iframe.height ) {
					// Calculate the proportion/ratio based on the width & height.
					proportion = parseFloat( iframe.width ) / parseFloat( iframe.height );
					// Get the parent element's width.
					parentWidth = parseFloat( window.getComputedStyle( iframe.parentElement, null ).width.replace( 'px', '' ) );
					// Set the max-width & height.
					iframe.style.maxWidth = '100%';
					iframe.style.maxHeight = Math.round( parentWidth / proportion ).toString() + 'px';
				}
			} );
		}

		// Document ready.
		$( document ).ready( function() {
			initResponsiveEmbeds();
		} );

		// Document resize.
		$( window ).on( 'resize', function() {
			initResponsiveEmbeds();
		} );

		// Post load.
		$( 'body' ).on( 'post-load', function() {
			initResponsiveEmbeds();
		} );

		// Run on initial load.
		initResponsiveEmbeds();
	} )();

	/**
	 * Fullscreen Search
	 */

	$( '.navbar .open-search' ).on( 'click', function( event ) {
		event.preventDefault();
		$( '.site-search' ).addClass( 'open' );
		$( '.site-search input[type="search"]' ).focus();
	} );

	$( '.site-search, .site-search button.close' ).on( 'click keyup', function( event ) {
		if ( event.target === this || event.target.className === 'close' || event.keyCode === 27 ) {
			$( this ).removeClass( 'open' );
		}
	} );
	/**
	 * Standard Carousel
	 */

	function initStandardCarousel() {
		/**
		 * Widget Post Featured
		 */
		$( '.pk-widget-posts-template-carousel > ul' ).each( function( index, container ) {

			$( container ).addClass( 'owl-carousel' );

			var rtl = $( 'body' ).hasClass( 'rtl' ) ? true : false;

			$( container ).imagesLoaded( function( instance ) {
				$( container ).owlCarousel( {
					rtl: rtl,
					loop: true,
					margin: 0,
					items: 1,
					dots: true,
					nav: false,
				} );
			} );

		} );

		/**
		 * Gallery Images
		 */
		$( '.post-container .gallery-type-slider' ).each( function( index, container ) {
			$( container ).addClass( 'owl-carousel' );

			var rtl = $( 'body' ).hasClass( 'rtl' ) ? true : false;

			$( container ).imagesLoaded( function( instance ) {
				$( container ).owlCarousel( {
					rtl: rtl,
					margin: 0,
					navText: [ '', '' ],
					autoHeight: true,
					responsive: {
						0: {
							margin: 0,
							merge: false,
							items: 1,
							dots: true,
							nav: false,
						},
						1000: {
							margin: 0,
							merge: true,
							items: 3,
							dots: false,
							nav: true,
						}
					},
				} );
			} );

		} );
	}

	$( document ).ready( function() {
		initStandardCarousel();
		$( document.body ).on( 'post-load', function() {
			initStandardCarousel();
		} );
	} );
	/**
	 * Sticky Sidebar
	 */

	var stickyElements = [];

	stickyElements.push( '.sticky-sidebar-enabled.stick-to-top .sidebar-1' );
	stickyElements.push( '.sticky-sidebar-enabled.stick-last .sidebar .widget:last-child' );

	$( document ).ready( function() {

		// Sticky sidebar for mozilla.
		if ( navigator.userAgent.toLowerCase().indexOf( 'firefox' ) > -1 ) {
			stickyElements.push( '.sticky-sidebar-enabled.stick-to-bottom .sidebar-1' );
		}

		// Join elements.
		stickyElements = stickyElements.join( ',' );

		// Sticky nav visible.
		$( document ).on( 'sticky-nav-visible', function() {
			var navBarHeight = $( '.navbar-primary' ).innerHeight();

			$( stickyElements ).css( 'top', 32 + navBarHeight + 'px' );
		} );

		// Sticky nav hide.
		$( document ).on( 'sticky-nav-hide', function() {
			$( stickyElements ).css( 'top', 32 + 'px' );
		} );

	} );

	/**
	 * Focus Shadow on Subscribe Field
	 */

	$( '.pk-subscribe-form-wrap input' ).focus( function() {
		$( this ).closest( 'form' ).addClass( 'cs-form-focus' );
	} );

	$( '.pk-subscribe-form-wrap input' ).blur( function() {
		$( this ).closest( 'form' ).removeClass( 'cs-form-focus' );
	} );
	$( document ).ready( function() {
		objectFitImages();
	} );

} )( jQuery );