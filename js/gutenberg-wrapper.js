/**
 * WordPress dependencies.
 */
const { Component }      = wp.element;
const { registerPlugin } = wp.plugins;

var cscoIframeContext = {};

function setIframeContext( key, val ) {
	cscoIframeContext[ key ] = val;
	sessionStorage.setItem( 'cscoIframeContext', JSON.stringify( cscoIframeContext ) );
}

class CSCOUpdateWrapper extends Component {
	/**
	 * Add initial class.
	 */
	componentDidMount() {
		const wrapper = document.querySelector( '.editor-styles-wrapper' );


		if ( wrapper ) {
			wrapper.classList.add( 'cs-editor-styles-wrapper' );

			wrapper.classList.add( cscoGWrapper.post_type );
			wrapper.classList.add( cscoGWrapper.page_layout );
		}
	}

	componentDidUpdate() {
		const wrapper = document.querySelector( '.editor-styles-wrapper' );

		if ( wrapper ) {
			wrapper.classList.add( 'cs-editor-styles-wrapper' );

			wrapper.classList.add( cscoGWrapper.post_type );
			wrapper.classList.add( cscoGWrapper.page_layout );
		}
	}

	render() {
		return null;
	}
}

/**
 * Update when page layout has changed.
 */
jQuery( 'select[name="csco_singular_sidebar"]' ).on( 'change', function() {
	var layout = jQuery( this ).val();

	jQuery( '.editor-styles-wrapper' ).removeClass( 'sidebar-disabled sidebar-enabled' );

	if ( 'right' === layout || 'left' === layout ) {
		cscoGWrapper.page_layout = 'sidebar-enabled';

		jQuery( '.editor-styles-wrapper' ).addClass( 'sidebar-enabled' );
	} else if ( 'disabled' === layout ) {
		cscoGWrapper.page_layout = 'sidebar-disabled';

		jQuery( '.editor-styles-wrapper' ).addClass( 'sidebar-disabled' );
	} else {
		cscoGWrapper.page_layout = cscoGWrapper.default_layout;

		jQuery( '.editor-styles-wrapper' ).addClass( cscoGWrapper.default_layout );
	}

	setIframeContext( 'page_layout', cscoGWrapper.page_layout );

});

registerPlugin( 'csco-editor-wrapper', { render: CSCOUpdateWrapper } );
