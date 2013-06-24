;(function($){
///<field name="cf7multiclick" type="library">plugin library</field>
window.cf7multiclick = {
	///<field name="_datakey" type="string">data indexer for settings</field>
	_datakey : 'cf7multiclick.active'
	,
	///<field name="_pending" type="string">pending class for form</field>
	_pending : 'cf7-pending'
	,
	_clickpause : function($o){
		///<summary>Generator fn to return 
		return function(e){
			///<summary>callback for submit click</summary>
			///<param name="e" type="Event">jQuery click event</param>
			
			// don't do anything if active
			if( $o.data(window.cf7multiclick._datakey) ) {
				e.preventDefault();
				return;
			}
			
			$o.data(window.cf7multiclick._datakey, true);
			$o.parents('form').addClass(window.cf7multiclick._pending);	// allow styling indication
		};
	}
	,
	pauseable : function(selector){
		///<summary>Make forms pausable</summary>
		///<param name="selector" type="string">target given field</param>
		$(function(){
			var $o = $(selector || '.wpcf7-submit');
			
			$o.click(window.cf7multiclick._clickpause($o));
		});
	}
	,
	reactivate : function(selector){
		///<summary>allow submissions again</summary>
		///<param name="selector" type="string">target given field</param>
		$(function(){
			var $o = $(selector || '.wpcf7-submit');
			
			$o.data(window.cf7multiclick._datakey, false); // okay again
			$o.parents('form').removeClass(window.cf7multiclick._pending);	// remove styling indication
		});
	}
};

})(jQuery);