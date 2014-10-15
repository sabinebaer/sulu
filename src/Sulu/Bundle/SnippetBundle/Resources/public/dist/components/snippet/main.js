define(["sulusnippet/model/snippet","app-config"],function(a,b){"use strict";var c="contentLanguage",d=function(){};return d.prototype={bindModelEvents:function(){this.sandbox.on("sulu.snippets.snippet.delete",function(){this.del()},this),this.sandbox.on("sulu.snippets.snippet.save",function(a){this.save(a)},this),this.sandbox.on("sulu.snippets.snippet.load",function(a,b){this.load(a,b)},this),this.sandbox.on("sulu.snippets.snippet.new",function(a){this.add(a)},this),this.sandbox.on("sulu.snippets.snippets.delete",function(a){this.delSnippets(a)},this),this.sandbox.on("sulu.snippets.snippet.list",function(){this.sandbox.emit("sulu.router.navigate","snippet/snippets")},this),this.sandbox.on("sulu.header.toolbar.language-changed",function(a){this.sandbox.sulu.saveUserSetting(c,a.localization);var b=this.content.toJSON();"index"===this.options.id&&(b.id=this.options.id),"edit"===this.type?this.sandbox.emit("sulu.snippets.snippet.load",b.id,a.localization):"add"===this.type?this.sandbox.emit("sulu.snippets.snippet.new",a.localization):this.sandbox.emit("sulu.snippets.snippet.list")},this)},del:function(){this.confirmDeleteDialog(function(a){a&&(this.sandbox.emit("sulu.header.toolbar.item.loading","options-button"),this.model.destroy({success:function(){this.sandbox.emit("sulu.router.navigate","snippet/snippets")}.bind(this)}))}.bind(this))},save:function(a){if(this.sandbox.emit("sulu.header.toolbar.item.loading","save-button"),this.template)a.template=this.template;else{var c=b.getSection("sulu-snippet");a.template=c.defaultType}this.model.set(a),this.model.fullSave(this.template,this.options.language,this.state,{},{success:function(a){var b=a.toJSON();this.data.id?this.sandbox.emit("sulu.snippets.snippet.saved",b):this.sandbox.emit("sulu.router.navigate","snippet/snippets/"+this.options.language+"/edit:"+b.id)}.bind(this),error:function(){this.sandbox.emit("sulu.snippets.snippet.save-error"),this.sandbox.logger.log("error while saving profile")}.bind(this)})},load:function(a,b){b||(b=this.options.language),this.sandbox.emit("sulu.router.navigate","snippet/snippets/"+b+"/edit:"+a)},add:function(a){a||(a=this.options.language),this.sandbox.emit("sulu.router.navigate","snippet/snippets/"+a+"/add")},delSnippets:function(b){return b.length<1?void this.sandbox.emit("sulu.dialog.error.show","No snippets selected for Deletion"):void this.confirmDeleteDialog(function(c){c&&b.forEach(function(b){var c=new a({id:b});c.destroy({success:function(){this.sandbox.emit("husky.datagrid.record.remove",b)}.bind(this)})}.bind(this))}.bind(this))},confirmDeleteDialog:function(a){if(a&&"function"!=typeof a)throw"callback is not a function";this.sandbox.emit("sulu.overlay.show-warning","sulu.overlay.be-careful","sulu.overlay.delete-desc",a.bind(this,!1),a.bind(this,!0))}},d});