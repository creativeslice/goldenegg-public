/* FUNCTION FOR TINYMCE CUSTOM BUTTON
 * Sets class of selected anchor to "button"
 * If selection is less than the entire anchor, function selects parent node. 
 * If selection is more than entire anchor - or if multiple anchors are selected within a div, function selects children nodes
 */
(function() {

    tinymce.PluginManager.add('egg_magic_button', function( editor, url ) {
       
    
        editor.addButton( 'egg_magic_button', {
        	title: 'Convert link to a Button',
			icon: 'backcolor',
            onclick: function() {
  				var ed = tinyMCE.activeEditor;
  				var parentNode = ed.dom.getParent(ed.selection.getNode());
				if( 'a' == parentNode.nodeName.toLowerCase()){ 
					ed.dom.addClass(ed.selection.select(parentNode), 'button');
				}
				else{
					var child = parentNode.firstChild;
					while(child){
					    if(child.nodeName.toLowerCase() == 'a'){
							ed.dom.addClass(ed.selection.select(child), 'button');
					    }
					    child = child.nextSibling;
					}
				}
            }
        });
    });
})();
(function() {
    tinymce.PluginManager.add('egg_no_wrap', function( editor, url ) {
            editor.addButton( 'egg_no_wrap', {
            title: 'No-Wrap',
			icon: 'nonbreaking',
            onclick: function() {
	            var orig_text = tinyMCE.activeEditor.selection.getContent();
				tinyMCE.activeEditor.selection.setContent("<span class='nowrap'>" + orig_text + "</span>");
            }
        });
    });
})();