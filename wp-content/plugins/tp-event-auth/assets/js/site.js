/*
 * @Author: ducnvtt
 * @Date:   2016-03-04 14:46:00
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-29 16:36:36
 */

'use strict';
(function($){

	var Event_Auth = {

		init: function (){
			this.register_form();
		},

		register_form: function (){
			$(document).on( 'submit', 'form.event_register', function(e){
				e.preventDefault();
				var _self = $(this),
						_data = _self.serializeArray(),
						button = _self.find( 'button[type="submit"]' );

				_self.find( '.event_auth_register_message_error' ).fadeOut().remove();
				$.ajax({
					url: event_auth_object.ajaxurl,
					type: 'POST',
					data: _data,
					beforeSend: function(){
						button.addClass('event-register-loading');
					}
				}).done( function( res ){
					button.removeClass('event-register-loading');
					if( typeof res.status === 'undefined' ) {
						Event_Auth.set_message( _self, event_auth_object.something_wrong ); return;
					}

					if( res.status === true && typeof res.url !== 'undefined' ) {
						window.location.href = res.url;
					}

					if ( typeof res.message !== 'undefined' ) {
						Event_Auth.set_message( _self, res.message ); return;
					}

				}).fail( function() {
					button.removeClass('event-register-loading');
					Event_Auth.set_message( _self, 'Something went wrong.' ); return;
				});
				// button.removeClass('event-register-loading');
				return false;
			});
		},

		set_message: function( form, message ){
			var html = [];
			html.push( '<div class="event_auth_register_message_error">' );
			html.push( '<p>' + message + '</p>' );
			html.push( '</div>' );

			form.find( '.event_register_submit' ).after( html.join('') );
		},
	};

	$(document).ready(function(){
		Event_Auth.init();
	});

})(jQuery);
