(function () {

	var cscoEditorIframe = {};

	if (window.self !== window.top) {

		var $this;

		cscoEditorIframe = {
			/*
			* Variables
			*/
			html: false,
			body: false,
			post_type: null,
			page_layout: null,
			prevStorageVal: null,

			/*
			* Initialize
			*/
			init: function( e ) {
				$this = cscoEditorIframe;

				// Find html and wrapper elements.
				$this.html = document.querySelector( 'html' );
				$this.body = document.querySelector( '.editor-styles-wrapper' );

				if ( ! $this || ! $this.html || ! $this.body ) {
					return;
				}

				$this.post_type    = cscoGWrapper.post_type;
				$this.page_layout  = cscoGWrapper.page_layout;

				$this.rootObserver();

				// Init events.
				if ( 'undefined' === typeof window.cscoEditorIframeInit ) {
					$this.events( e );

					window.cscoEditorIframeInit = true;
				}
			},

			/*
			* Events
			*/
			events: function( e ) {
				// Listen storage from the parent window
				setInterval(() => {
					const currentValue = sessionStorage.getItem('cscoIframeContext');
					if (currentValue !== $this.prevStorageVal) {

						$this.prevStorageVal = currentValue;

						if ( currentValue ) {
							let data = JSON.parse(currentValue);

							if ( data.hasOwnProperty( 'page_layout' ) ) {
								$this.page_layout = data.page_layout;
								$this.setLayout();
							}
						}
					}
				}, 100);

				// Listen HTML and Body elements.
				var observer = new MutationObserver( function( mutations ) {
					mutations.forEach( function( mutation ) {
						if ( mutation.oldValue !== mutation.target.classList.value ) {
							$this.rootObserver();
						}
					} );
				} );

				observer.observe( $this.html, {
					attributes: true,
					subtree: false,
					attributeOldValue: true,
					attributeFilter: [ "class" ],
				} );

				observer.observe( $this.body, {
					attributes: true,
					subtree: false,
					attributeOldValue: true,
					attributeFilter: [ "class" ],
				} );
			},

			/**
			 * Function for Listener HTML and Body elements.
			 */
			rootObserver: function() {
				let update = false;

				if (!$this.html.classList.contains('cs-editor-iframe')) {
					$this.html.classList.add( 'cs-editor-iframe' );
					update = true;
				}

				if (!$this.body.classList.contains('cs-editor-styles-wrapper')) {
					$this.body.classList.add( 'cs-editor-styles-wrapper' );
					update = true;
				}

				if ( update ) {
					$this.setLayout();
				}
			},

			/**
			 * Set layout.
			 */
			setLayout: function() {
				$this.body.classList.remove( 'sidebar-enabled' );
				$this.body.classList.remove( 'sidebar-disabled' );

				$this.body.classList.add( $this.page_layout );
				$this.body.classList.add( $this.post_type );
			},
		}

		// Iframe Loaded.
		if ( document.readyState === 'complete' || document.readyState === 'interactive' ) {
			cscoEditorIframe.init();
		} else {
			document.addEventListener('DOMContentLoaded', function(){
				cscoEditorIframe.init();
			});
		}
	}
})();
