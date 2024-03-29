/*

Script: Tabs.js
	Creates a tab list control

Copyright:
	Copyright (c) 2010 Chris Doty, <http://polaropposite.com/>.

License:
	MIT-style license.

*/

MUI.files[MUI.path.plugins + 'MUI/Tabs/Tabs.js'] = 'loaded';

MUI.Tabs = new Class({

Implements: [Events, Options],

options: {
     id:            ''              // id of the primary element, and id os control that is registered with mocha
    ,container:     null            // the parent control in the document to add the control to
    ,createOnInit:  true            // true to add tree to container when control is initialized
    ,cssClass:      'tabs'          // the primary css tag

    ,tabs:         $A([])           // the list of tabs

    ,textField:     'text'          // the name of the field that has the node's text
    ,valueField:    'value'         // the name of the field that has the node's value
    ,titleField:    'title'         // the name of the field that has the node's tip text

    ,value:         ''              // the currently selected tab's value
    ,selectedTab:   null            // the currently selected tab

    ,onTabSelected: $empty          // event: when a node is checked
},

initialize: function( options )
{
    var self=this;
    self.setOptions(options);
    var o=self.options;

    // make sure this controls has an ID
    var id=o.id;
    if(!id) { id='tabs' + (++MUI.IDCount); o.id=id; }

    // create sub items if available
    if(o.createOnInit && o.tabs.length>0) this.toDOM();
    else {
        window.addEvent('domready', function() {
            var el=$(id);
            if(el!=null) self.fromHTML();
        });
    }

    MUI.set(id,this);    
},

_getData: function(item,property){
    if(!item || !property) return '';
    if(item[property]==null) return '';
    return item[property];
},

fromHTML: function(el)
{
    var self=this;
    var o=self.options;
    if(!el) el = $(o.id);
    else el=$(el);
    if(!el) return;

    o.cssClass = el.get('class');

    var tabs=$A([]);
    el.getElements('li').each(function(li){
        var tab={};

        var value=li.get('id');
        if(!value) value='tab' + (++MUI.IDCount);

        var a=li.getElement('a');
        var title=a.get('title');

        tab[o.valueField] = value;
        tab[o.textField] = a.get('text');
        if(title) tab[o.titleField]=title;

        tabs.push(tab);
    });
    o.tabs = tabs;
    self.toDOM();
},

toDOM: function(containerEl)
{
    var self=this;        
    var o=self.options;

    var isNew = false;
    var div=$(o.id);
    var ul;
    if(!div) {
        div=new Element('div',{'id':o.id});
        isNew=true;
    } else ul=div.getElement('ul');
    if(!ul) ul=new Element('ul').inject(div);
    else ul.empty();
    if(o.cssClass) {
        div.set('class',o.cssClass);
        ul.set('class',o.cssClass);
    }
    self.element = div;   

    // if no tab selected, then select first tab for them
    if(o.tabs.length>0 && (o.value==null || o.value=='')) o.value=self._getData(o.tabs[0],o.valueField);

    // build all tabs
    $A(o.tabs).each(function(tab) { self.buildTab(tab,ul); } );

    // add a formatting div
    new Element('div',{'class':'clear'}).inject(ul);

    if(!isNew) return this;

    window.addEvent('domready', function() {
        var container=$(containerEl ? containerEl : o.container);
        container.appendChild(div);
    });

    return div;
},

buildTab: function(tab,ul) {
    var self = this;
    var o=self.options;

    var value=self._getData(tab,o.valueField);
    if(!value) value='tab' + (++MUI.IDCount);
    var text=self._getData(tab,o.textField);
    var title=self._getData(tab,o.titleField);

    var li=new Element('li',{'id':value}).inject(ul);
    var a=new Element('a',{'text':text}).inject(li);
    tab._element = li;

    li.addEvent('click',function(e) { self.onTabClick(tab,ul,e); });
    a.addEvent('click',function(e) { e.preventDefault(); });
    if(title) a.set('title',title);
    else a.set('title',text);
    
    if(o.value == value) li.addClass('sel');
},

onTabClick: function(tab,ul,e) {
    var self=this;
    var o=self.options;
    e.stopPropagation();

    var value=self._getData(tab,o.valueField);
    if(value==null) value=self._getData(tab,o.textField);
    o.value=value;
    o.selectedTab = tab;

    ul.getChildren().each(function(listItem){
        listItem.removeClass('sel');
    });
    tab._element.addClass('sel');

    self.fireEvent('tabSelected',[tab,value,self,e]);
}

});
