/* FUNCTION FOR TINYMCE CUSTOM BUTTON
 * Sets class of selected anchor to "button"
 * If selection is less than the entire anchor, function selects parent node. 
 * If selection is more than entire anchor - or if multiple anchors are selected within a div, function selects children nodes
 */
(function() {
    tinymce.PluginManager.add('egg_magic_button', function( editor, url ) {
        editor.addButton( 'egg_magic_button', {
            text: 'Create Button',
            icon: false,
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