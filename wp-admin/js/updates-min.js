!function(e,t,a){var s=e(document);(t=t||{}).updates={},t.updates.ajaxNonce=a.ajax_nonce,t.updates.l10n=a.l10n,t.updates.searchTerm="",t.updates.shouldRequestFilesystemCredentials=!1,t.updates.filesystemCredentials={ftp:{host:"",username:"",password:"",connectionType:""},ssh:{publicKey:"",privateKey:""},fsNonce:"",available:!1},t.updates.ajaxLocked=!1,t.updates.adminNotice=t.template("wp-updates-admin-notice"),t.updates.queue=[],t.updates.$elToReturnFocusToFromCredentialsModal=void 0,t.updates.addAdminNotice=function(a){var n,l=e(a.selector),i=e(".wp-header-end");delete a.selector,n=t.updates.adminNotice(a),l.length||(l=e("#"+a.id)),l.length?l.replaceWith(n):i.length?i.after(n):"customize"===pagenow?e(".customize-themes-notifications").append(n):e(".wrap").find("> h1").after(n),s.trigger("wp-updates-notice-added")},t.updates.ajax=function(a,s){var n={};return t.updates.ajaxLocked?(t.updates.queue.push({action:a,data:s}),e.Deferred()):(t.updates.ajaxLocked=!0,s.success&&(n.success=s.success,delete s.success),s.error&&(n.error=s.error,delete s.error),n.data=_.extend(s,{action:a,_ajax_nonce:t.updates.ajaxNonce,_fs_nonce:t.updates.filesystemCredentials.fsNonce,username:t.updates.filesystemCredentials.ftp.username,password:t.updates.filesystemCredentials.ftp.password,hostname:t.updates.filesystemCredentials.ftp.hostname,connection_type:t.updates.filesystemCredentials.ftp.connectionType,public_key:t.updates.filesystemCredentials.ssh.publicKey,private_key:t.updates.filesystemCredentials.ssh.privateKey}),t.ajax.send(n).always(t.updates.ajaxAlways))},t.updates.ajaxAlways=function(e){e.errorCode&&"unable_to_connect_to_filesystem"===e.errorCode||(t.updates.ajaxLocked=!1,t.updates.queueChecker()),void 0!==e.debug&&window.console&&window.console.log&&_.map(e.debug,function(e){window.console.log(t.sanitize.stripTagsAndEncodeText(e))})},t.updates.refreshCount=function(){var t,s=e("#wp-admin-bar-updates"),n=e('a[href="update-core.php"] .update-plugins'),l=e('a[href="plugins.php"] .update-plugins'),i=e('a[href="themes.php"] .update-plugins');s.find(".ab-item").removeAttr("title"),s.find(".ab-label").text(a.totals.counts.total),0===a.totals.counts.total&&s.find(".ab-label").parents("li").remove(),n.each(function(e,t){t.className=t.className.replace(/count-\d+/,"count-"+a.totals.counts.total)}),a.totals.counts.total>0?n.find(".update-count").text(a.totals.counts.total):n.remove(),l.each(function(e,t){t.className=t.className.replace(/count-\d+/,"count-"+a.totals.counts.plugins)}),a.totals.counts.total>0?l.find(".plugin-count").text(a.totals.counts.plugins):l.remove(),i.each(function(e,t){t.className=t.className.replace(/count-\d+/,"count-"+a.totals.counts.themes)}),a.totals.counts.total>0?i.find(".theme-count").text(a.totals.counts.themes):i.remove(),"plugins"===pagenow||"plugins-network"===pagenow?t=a.totals.counts.plugins:"themes"!==pagenow&&"themes-network"!==pagenow||(t=a.totals.counts.themes),t>0?e(".subsubsub .upgrade .count").text("("+t+")"):(e(".subsubsub .upgrade").remove(),e(".subsubsub li:last").html(function(){return e(this).children()}))},t.updates.decrementCount=function(e){a.totals.counts.total=Math.max(--a.totals.counts.total,0),"plugin"===e?a.totals.counts.plugins=Math.max(--a.totals.counts.plugins,0):"theme"===e&&(a.totals.counts.themes=Math.max(--a.totals.counts.themes,0)),t.updates.refreshCount(e)},t.updates.updatePlugin=function(a){var n,l,i,d;return a=_.extend({success:t.updates.updatePluginSuccess,error:t.updates.updatePluginError},a),"plugins"===pagenow||"plugins-network"===pagenow?(i=(n=e('tr[data-plugin="'+a.plugin+'"]')).find(".update-message").removeClass("notice-error").addClass("updating-message notice-warning").find("p"),d=t.updates.l10n.pluginUpdatingLabel.replace("%s",n.find(".plugin-title strong").text())):"plugin-install"!==pagenow&&"plugin-install-network"!==pagenow||(i=(l=e(".plugin-card-"+a.slug)).find(".update-now").addClass("updating-message"),d=t.updates.l10n.pluginUpdatingLabel.replace("%s",i.data("name")),l.removeClass("plugin-card-update-failed").find(".notice.notice-error").remove()),i.html()!==t.updates.l10n.updating&&i.data("originaltext",i.html()),i.attr("aria-label",d).text(t.updates.l10n.updating),s.trigger("wp-plugin-updating",a),t.updates.ajax("update-plugin",a)},t.updates.updatePluginSuccess=function(a){var n,l,i;"plugins"===pagenow||"plugins-network"===pagenow?(l=(n=e('tr[data-plugin="'+a.plugin+'"]').removeClass("update").addClass("updated")).find(".update-message").removeClass("updating-message notice-warning").addClass("updated-message notice-success").find("p"),i=n.find(".plugin-version-author-uri").html().replace(a.oldVersion,a.newVersion),n.find(".plugin-version-author-uri").html(i)):"plugin-install"!==pagenow&&"plugin-install-network"!==pagenow||(l=e(".plugin-card-"+a.slug).find(".update-now").removeClass("updating-message").addClass("button-disabled updated-message")),l.attr("aria-label",t.updates.l10n.pluginUpdatedLabel.replace("%s",a.pluginName)).text(t.updates.l10n.pluginUpdated),t.a11y.speak(t.updates.l10n.updatedMsg,"polite"),t.updates.decrementCount("plugin"),s.trigger("wp-plugin-update-success",a)},t.updates.updatePluginError=function(a){var n,l,i;t.updates.isValidResponse(a,"update")&&(t.updates.maybeHandleCredentialError(a,"update-plugin")||(i=t.updates.l10n.updateFailed.replace("%s",a.errorMessage),"plugins"===pagenow||"plugins-network"===pagenow?((l=a.plugin?e('tr[data-plugin="'+a.plugin+'"]').find(".update-message"):e('tr[data-slug="'+a.slug+'"]').find(".update-message")).removeClass("updating-message notice-warning").addClass("notice-error").find("p").html(i),a.pluginName?l.find("p").attr("aria-label",t.updates.l10n.pluginUpdateFailedLabel.replace("%s",a.pluginName)):l.find("p").removeAttr("aria-label")):"plugin-install"!==pagenow&&"plugin-install-network"!==pagenow||((n=e(".plugin-card-"+a.slug).addClass("plugin-card-update-failed").append(t.updates.adminNotice({className:"update-message notice-error notice-alt is-dismissible",message:i}))).find(".update-now").text(t.updates.l10n.updateFailedShort).removeClass("updating-message"),a.pluginName?n.find(".update-now").attr("aria-label",t.updates.l10n.pluginUpdateFailedLabel.replace("%s",a.pluginName)):n.find(".update-now").removeAttr("aria-label"),n.on("click",".notice.is-dismissible .notice-dismiss",function(){setTimeout(function(){n.removeClass("plugin-card-update-failed").find(".column-name a").focus(),n.find(".update-now").attr("aria-label",!1).text(t.updates.l10n.updateNow)},200)})),t.a11y.speak(i,"assertive"),s.trigger("wp-plugin-update-error",a)))},t.updates.installPlugin=function(a){var n=e(".plugin-card-"+a.slug),l=n.find(".install-now");return a=_.extend({success:t.updates.installPluginSuccess,error:t.updates.installPluginError},a),"import"===pagenow&&(l=e('[data-slug="'+a.slug+'"]')),l.html()!==t.updates.l10n.installing&&l.data("originaltext",l.html()),l.addClass("updating-message").attr("aria-label",t.updates.l10n.pluginInstallingLabel.replace("%s",l.data("name"))).text(t.updates.l10n.installing),t.a11y.speak(t.updates.l10n.installingMsg,"polite"),n.removeClass("plugin-card-install-failed").find(".notice.notice-error").remove(),s.trigger("wp-plugin-installing",a),t.updates.ajax("install-plugin",a)},t.updates.installPluginSuccess=function(a){var n=e(".plugin-card-"+a.slug).find(".install-now");n.removeClass("updating-message").addClass("updated-message installed button-disabled").attr("aria-label",t.updates.l10n.pluginInstalledLabel.replace("%s",a.pluginName)).text(t.updates.l10n.pluginInstalled),t.a11y.speak(t.updates.l10n.installedMsg,"polite"),s.trigger("wp-plugin-install-success",a),a.activateUrl&&setTimeout(function(){n.removeClass("install-now installed button-disabled updated-message").addClass("activate-now button-primary").attr("href",a.activateUrl).attr("aria-label",t.updates.l10n.activatePluginLabel.replace("%s",a.pluginName)).text(t.updates.l10n.activatePlugin)},1e3)},t.updates.installPluginError=function(a){var n,l=e(".plugin-card-"+a.slug),i=l.find(".install-now");t.updates.isValidResponse(a,"install")&&(t.updates.maybeHandleCredentialError(a,"install-plugin")||(n=t.updates.l10n.installFailed.replace("%s",a.errorMessage),l.addClass("plugin-card-update-failed").append('<div class="notice notice-error notice-alt is-dismissible"><p>'+n+"</p></div>"),l.on("click",".notice.is-dismissible .notice-dismiss",function(){setTimeout(function(){l.removeClass("plugin-card-update-failed").find(".column-name a").focus()},200)}),i.removeClass("updating-message").addClass("button-disabled").attr("aria-label",t.updates.l10n.pluginInstallFailedLabel.replace("%s",i.data("name"))).text(t.updates.l10n.installFailedShort),t.a11y.speak(n,"assertive"),s.trigger("wp-plugin-install-error",a)))},t.updates.installImporterSuccess=function(a){t.updates.addAdminNotice({id:"install-success",className:"notice-success is-dismissible",message:t.updates.l10n.importerInstalledMsg.replace("%s",a.activateUrl+"&from=import")}),e('[data-slug="'+a.slug+'"]').removeClass("install-now updating-message").addClass("activate-now").attr({href:a.activateUrl+"&from=import","aria-label":t.updates.l10n.activateImporterLabel.replace("%s",a.pluginName)}).text(t.updates.l10n.activateImporter),t.a11y.speak(t.updates.l10n.installedMsg,"polite"),s.trigger("wp-importer-install-success",a)},t.updates.installImporterError=function(a){var n=t.updates.l10n.installFailed.replace("%s",a.errorMessage),l=e('[data-slug="'+a.slug+'"]'),i=l.data("name");t.updates.isValidResponse(a,"install")&&(t.updates.maybeHandleCredentialError(a,"install-plugin")||(t.updates.addAdminNotice({id:a.errorCode,className:"notice-error is-dismissible",message:n}),l.removeClass("updating-message").text(t.updates.l10n.installNow).attr("aria-label",t.updates.l10n.pluginInstallNowLabel.replace("%s",i)),t.a11y.speak(n,"assertive"),s.trigger("wp-importer-install-error",a)))},t.updates.deletePlugin=function(a){var n=e('[data-plugin="'+a.plugin+'"]').find(".row-actions a.delete");return a=_.extend({success:t.updates.deletePluginSuccess,error:t.updates.deletePluginError},a),n.html()!==t.updates.l10n.deleting&&n.data("originaltext",n.html()).text(t.updates.l10n.deleting),t.a11y.speak(t.updates.l10n.deleting,"polite"),s.trigger("wp-plugin-deleting",a),t.updates.ajax("delete-plugin",a)},t.updates.deletePluginSuccess=function(n){e('[data-plugin="'+n.plugin+'"]').css({backgroundColor:"#faafaa"}).fadeOut(350,function(){var s=e("#bulk-action-form"),l=e(".subsubsub"),i=e(this),d=s.find("thead th:not(.hidden), thead td").length,u=t.template("item-deleted-row"),r=a.plugins;i.hasClass("plugin-update-tr")||i.after(u({slug:n.slug,plugin:n.plugin,colspan:d,name:n.pluginName})),i.remove(),-1!==_.indexOf(r.upgrade,n.plugin)&&(r.upgrade=_.without(r.upgrade,n.plugin),t.updates.decrementCount("plugin")),-1!==_.indexOf(r.inactive,n.plugin)&&(r.inactive=_.without(r.inactive,n.plugin),r.inactive.length?l.find(".inactive .count").text("("+r.inactive.length+")"):l.find(".inactive").remove()),-1!==_.indexOf(r.active,n.plugin)&&(r.active=_.without(r.active,n.plugin),r.active.length?l.find(".active .count").text("("+r.active.length+")"):l.find(".active").remove()),-1!==_.indexOf(r.recently_activated,n.plugin)&&(r.recently_activated=_.without(r.recently_activated,n.plugin),r.recently_activated.length?l.find(".recently_activated .count").text("("+r.recently_activated.length+")"):l.find(".recently_activated").remove()),r.all=_.without(r.all,n.plugin),r.all.length?l.find(".all .count").text("("+r.all.length+")"):(s.find(".tablenav").css({visibility:"hidden"}),l.find(".all").remove(),s.find("tr.no-items").length||s.find("#the-list").append('<tr class="no-items"><td class="colspanchange" colspan="'+d+'">'+t.updates.l10n.noPlugins+"</td></tr>"))}),t.a11y.speak(t.updates.l10n.pluginDeleted,"polite"),s.trigger("wp-plugin-delete-success",n)},t.updates.deletePluginError=function(a){var n,l,i=t.template("item-update-row"),d=t.updates.adminNotice({className:"update-message notice-error notice-alt",message:a.errorMessage});l=a.plugin?(n=e('tr.inactive[data-plugin="'+a.plugin+'"]')).siblings('[data-plugin="'+a.plugin+'"]'):(n=e('tr.inactive[data-slug="'+a.slug+'"]')).siblings('[data-slug="'+a.slug+'"]'),t.updates.isValidResponse(a,"delete")&&(t.updates.maybeHandleCredentialError(a,"delete-plugin")||(l.length?(l.find(".notice-error").remove(),l.find(".plugin-update").append(d)):n.addClass("update").after(i({slug:a.slug,plugin:a.plugin||a.slug,colspan:e("#bulk-action-form").find("thead th:not(.hidden), thead td").length,content:d})),s.trigger("wp-plugin-delete-error",a)))},t.updates.updateTheme=function(a){var n;return a=_.extend({success:t.updates.updateThemeSuccess,error:t.updates.updateThemeError},a),"themes-network"===pagenow?n=e('[data-slug="'+a.slug+'"]').find(".update-message").removeClass("notice-error").addClass("updating-message notice-warning").find("p"):"customize"===pagenow?((n=e('[data-slug="'+a.slug+'"].notice').removeClass("notice-large")).find("h3").remove(),n=(n=n.add(e("#customize-control-installed_theme_"+a.slug).find(".update-message"))).addClass("updating-message").find("p")):((n=e("#update-theme").closest(".notice").removeClass("notice-large")).find("h3").remove(),n=(n=n.add(e('[data-slug="'+a.slug+'"]').find(".update-message"))).addClass("updating-message").find("p")),n.html()!==t.updates.l10n.updating&&n.data("originaltext",n.html()),t.a11y.speak(t.updates.l10n.updatingMsg,"polite"),n.text(t.updates.l10n.updating),s.trigger("wp-theme-updating",a),t.updates.ajax("update-theme",a)},t.updates.updateThemeSuccess=function(a){var n,l,i=e("body.modal-open").length,d=e('[data-slug="'+a.slug+'"]'),u={className:"updated-message notice-success notice-alt",message:t.updates.l10n.themeUpdated};"customize"===pagenow?((d=e(".updating-message").siblings(".theme-name")).length&&(l=d.html().replace(a.oldVersion,a.newVersion),d.html(l)),n=e(".theme-info .notice").add(t.customize.control("installed_theme_"+a.slug).container.find(".theme").find(".update-message"))):"themes-network"===pagenow?(n=d.find(".update-message"),l=d.find(".theme-version-author-uri").html().replace(a.oldVersion,a.newVersion),d.find(".theme-version-author-uri").html(l)):(n=e(".theme-info .notice").add(d.find(".update-message")),i?e(".load-customize:visible").focus():d.find(".load-customize").focus()),t.updates.addAdminNotice(_.extend({selector:n},u)),t.a11y.speak(t.updates.l10n.updatedMsg,"polite"),t.updates.decrementCount("theme"),s.trigger("wp-theme-update-success",a),i&&"customize"!==pagenow&&e(".theme-info .theme-author").after(t.updates.adminNotice(u))},t.updates.updateThemeError=function(a){var n,l=e('[data-slug="'+a.slug+'"]'),i=t.updates.l10n.updateFailed.replace("%s",a.errorMessage);t.updates.isValidResponse(a,"update")&&(t.updates.maybeHandleCredentialError(a,"update-theme")||("customize"===pagenow&&(l=t.customize.control("installed_theme_"+a.slug).container.find(".theme")),"themes-network"===pagenow?n=l.find(".update-message "):(n=e(".theme-info .notice").add(l.find(".notice")),e("body.modal-open").length?e(".load-customize:visible").focus():l.find(".load-customize").focus()),t.updates.addAdminNotice({selector:n,className:"update-message notice-error notice-alt is-dismissible",message:i}),t.a11y.speak(i,"polite"),s.trigger("wp-theme-update-error",a)))},t.updates.installTheme=function(a){var n=e('.theme-install[data-slug="'+a.slug+'"]');return a=_.extend({success:t.updates.installThemeSuccess,error:t.updates.installThemeError},a),n.addClass("updating-message"),n.parents(".theme").addClass("focus"),n.html()!==t.updates.l10n.installing&&n.data("originaltext",n.html()),n.text(t.updates.l10n.installing).attr("aria-label",t.updates.l10n.themeInstallingLabel.replace("%s",n.data("name"))),t.a11y.speak(t.updates.l10n.installingMsg,"polite"),e('.install-theme-info, [data-slug="'+a.slug+'"]').removeClass("theme-install-failed").find(".notice.notice-error").remove(),s.trigger("wp-theme-installing",a),t.updates.ajax("install-theme",a)},t.updates.installThemeSuccess=function(a){var n,l=e(".wp-full-overlay-header, [data-slug="+a.slug+"]");s.trigger("wp-theme-install-success",a),n=l.find(".button-primary").removeClass("updating-message").addClass("updated-message disabled").attr("aria-label",t.updates.l10n.themeInstalledLabel.replace("%s",a.themeName)).text(t.updates.l10n.themeInstalled),t.a11y.speak(t.updates.l10n.installedMsg,"polite"),setTimeout(function(){a.activateUrl&&n.attr("href",a.activateUrl).removeClass("theme-install updated-message disabled").addClass("activate").attr("aria-label",t.updates.l10n.activateThemeLabel.replace("%s",a.themeName)).text(t.updates.l10n.activateTheme),a.customizeUrl&&n.siblings(".preview").replaceWith(function(){return e("<a>").attr("href",a.customizeUrl).addClass("button load-customize").text(t.updates.l10n.livePreview)})},1e3)},t.updates.installThemeError=function(a){var n,l=t.updates.l10n.installFailed.replace("%s",a.errorMessage),i=t.updates.adminNotice({className:"update-message notice-error notice-alt",message:l});t.updates.isValidResponse(a,"install")&&(t.updates.maybeHandleCredentialError(a,"install-theme")||("customize"===pagenow?(s.find("body").hasClass("modal-open")?(n=e('.theme-install[data-slug="'+a.slug+'"]'),e(".theme-overlay .theme-info").prepend(i)):(n=e('.theme-install[data-slug="'+a.slug+'"]')).closest(".theme").addClass("theme-install-failed").append(i),t.customize.notifications.remove("theme_installing")):s.find("body").hasClass("full-overlay-active")?(n=e('.theme-install[data-slug="'+a.slug+'"]'),e(".install-theme-info").prepend(i)):n=e('[data-slug="'+a.slug+'"]').removeClass("focus").addClass("theme-install-failed").append(i).find(".theme-install"),n.removeClass("updating-message").attr("aria-label",t.updates.l10n.themeInstallFailedLabel.replace("%s",n.data("name"))).text(t.updates.l10n.installFailedShort),t.a11y.speak(l,"assertive"),s.trigger("wp-theme-install-error",a)))},t.updates.deleteTheme=function(a){var n;return"themes"===pagenow?n=e(".theme-actions .delete-theme"):"themes-network"===pagenow&&(n=e('[data-slug="'+a.slug+'"]').find(".row-actions a.delete")),a=_.extend({success:t.updates.deleteThemeSuccess,error:t.updates.deleteThemeError},a),n&&n.html()!==t.updates.l10n.deleting&&n.data("originaltext",n.html()).text(t.updates.l10n.deleting),t.a11y.speak(t.updates.l10n.deleting,"polite"),e(".theme-info .update-message").remove(),s.trigger("wp-theme-deleting",a),t.updates.ajax("delete-theme",a)},t.updates.deleteThemeSuccess=function(n){var l=e('[data-slug="'+n.slug+'"]');"themes-network"===pagenow&&l.css({backgroundColor:"#faafaa"}).fadeOut(350,function(){var s=e(".subsubsub"),l=e(this),i=a.themes,d=t.template("item-deleted-row");l.hasClass("plugin-update-tr")||l.after(d({slug:n.slug,colspan:e("#bulk-action-form").find("thead th:not(.hidden), thead td").length,name:l.find(".theme-title strong").text()})),l.remove(),l.hasClass("update")&&(i.upgrade--,t.updates.decrementCount("theme")),l.hasClass("inactive")&&(i.disabled--,i.disabled?s.find(".disabled .count").text("("+i.disabled+")"):s.find(".disabled").remove()),s.find(".all .count").text("("+--i.all+")")}),t.a11y.speak(t.updates.l10n.themeDeleted,"polite"),s.trigger("wp-theme-delete-success",n)},t.updates.deleteThemeError=function(a){var n=e('tr.inactive[data-slug="'+a.slug+'"]'),l=e(".theme-actions .delete-theme"),i=t.template("item-update-row"),d=n.siblings("#"+a.slug+"-update"),u=t.updates.l10n.deleteFailed.replace("%s",a.errorMessage),r=t.updates.adminNotice({className:"update-message notice-error notice-alt",message:u});t.updates.maybeHandleCredentialError(a,"delete-theme")||("themes-network"===pagenow?d.length?(d.find(".notice-error").remove(),d.find(".plugin-update").append(r)):n.addClass("update").after(i({slug:a.slug,colspan:e("#bulk-action-form").find("thead th:not(.hidden), thead td").length,content:r})):e(".theme-info .theme-description").before(r),l.html(l.data("originaltext")),t.a11y.speak(u,"assertive"),s.trigger("wp-theme-delete-error",a))},t.updates._addCallbacks=function(e,a){return"import"===pagenow&&"install-plugin"===a&&(e.success=t.updates.installImporterSuccess,e.error=t.updates.installImporterError),e},t.updates.queueChecker=function(){var e;if(!t.updates.ajaxLocked&&t.updates.queue.length)switch((e=t.updates.queue.shift()).action){case"install-plugin":t.updates.installPlugin(e.data);break;case"update-plugin":t.updates.updatePlugin(e.data);break;case"delete-plugin":t.updates.deletePlugin(e.data);break;case"install-theme":t.updates.installTheme(e.data);break;case"update-theme":t.updates.updateTheme(e.data);break;case"delete-theme":t.updates.deleteTheme(e.data)}},t.updates.requestFilesystemCredentials=function(a){!1===t.updates.filesystemCredentials.available&&(a&&!t.updates.$elToReturnFocusToFromCredentialsModal&&(t.updates.$elToReturnFocusToFromCredentialsModal=e(a.target)),t.updates.ajaxLocked=!0,t.updates.requestForCredentialsModalOpen())},t.updates.maybeRequestFilesystemCredentials=function(e){t.updates.shouldRequestFilesystemCredentials&&!t.updates.ajaxLocked&&t.updates.requestFilesystemCredentials(e)},t.updates.keydown=function(a){27===a.keyCode?t.updates.requestForCredentialsModalCancel():9===a.keyCode&&("upgrade"!==a.target.id||a.shiftKey?"hostname"===a.target.id&&a.shiftKey&&(e("#upgrade").focus(),a.preventDefault()):(e("#hostname").focus(),a.preventDefault()))},t.updates.requestForCredentialsModalOpen=function(){var a=e("#request-filesystem-credentials-dialog");e("body").addClass("modal-open"),a.show(),a.find("input:enabled:first").focus(),a.on("keydown",t.updates.keydown)},t.updates.requestForCredentialsModalClose=function(){e("#request-filesystem-credentials-dialog").hide(),e("body").removeClass("modal-open"),t.updates.$elToReturnFocusToFromCredentialsModal&&t.updates.$elToReturnFocusToFromCredentialsModal.focus()},t.updates.requestForCredentialsModalCancel=function(){(t.updates.ajaxLocked||t.updates.queue.length)&&(_.each(t.updates.queue,function(e){s.trigger("credential-modal-cancel",e)}),t.updates.ajaxLocked=!1,t.updates.queue=[],t.updates.requestForCredentialsModalClose())},t.updates.showErrorInCredentialsForm=function(t){var a=e("#request-filesystem-credentials-form");a.find(".notice").remove(),a.find("#request-filesystem-credentials-title").after('<div class="notice notice-alt notice-error"><p>'+t+"</p></div>")},t.updates.credentialError=function(e,a){e=t.updates._addCallbacks(e,a),t.updates.queue.unshift({action:a,data:e}),t.updates.filesystemCredentials.available=!1,t.updates.showErrorInCredentialsForm(e.errorMessage),t.updates.requestFilesystemCredentials()},t.updates.maybeHandleCredentialError=function(e,a){return!(!t.updates.shouldRequestFilesystemCredentials||!e.errorCode||"unable_to_connect_to_filesystem"!==e.errorCode)&&(t.updates.credentialError(e,a),!0)},t.updates.isValidResponse=function(a,s){var n,l=t.updates.l10n.unknownError;if(_.isObject(a)&&!_.isFunction(a.always))return!0;switch(_.isString(a)&&"-1"===a?l=t.updates.l10n.nonceError:_.isString(a)?l=a:void 0!==a.readyState&&0===a.readyState?l=t.updates.l10n.connectionError:_.isString(a.responseText)&&""!==a.responseText?l=a.responseText:_.isString(a.statusText)&&(l=a.statusText),s){case"update":n=t.updates.l10n.updateFailed;break;case"install":n=t.updates.l10n.installFailed;break;case"delete":n=t.updates.l10n.deleteFailed}return l=l.replace(/<[\/a-z][^<>]*>/gi,""),n=n.replace("%s",l),t.updates.addAdminNotice({id:"unknown_error",className:"notice-error is-dismissible",message:_.escape(n)}),t.updates.ajaxLocked=!1,t.updates.queue=[],e(".button.updating-message").removeClass("updating-message").removeAttr("aria-label").prop("disabled",!0).text(t.updates.l10n.updateFailedShort),e(".updating-message:not(.button):not(.thickbox)").removeClass("updating-message notice-warning").addClass("notice-error").find("p").removeAttr("aria-label").text(n),t.a11y.speak(n,"assertive"),!1},t.updates.beforeunload=function(){if(t.updates.ajaxLocked)return t.updates.l10n.beforeunload},e(function(){var n=e("#plugin-filter"),l=e("#bulk-action-form"),i=e("#request-filesystem-credentials-form"),d=e("#request-filesystem-credentials-dialog"),u=e(".plugins-php .wp-filter-search"),r=e(".plugin-install-php .wp-filter-search");(a=_.extend(a,window._wpUpdatesItemCounts||{})).totals&&t.updates.refreshCount(),t.updates.shouldRequestFilesystemCredentials=d.length>0,d.on("submit","form",function(a){a.preventDefault(),t.updates.filesystemCredentials.ftp.hostname=e("#hostname").val(),t.updates.filesystemCredentials.ftp.username=e("#username").val(),t.updates.filesystemCredentials.ftp.password=e("#password").val(),t.updates.filesystemCredentials.ftp.connectionType=e('input[name="connection_type"]:checked').val(),t.updates.filesystemCredentials.ssh.publicKey=e("#public_key").val(),t.updates.filesystemCredentials.ssh.privateKey=e("#private_key").val(),t.updates.filesystemCredentials.fsNonce=e("#_fs_nonce").val(),t.updates.filesystemCredentials.available=!0,t.updates.ajaxLocked=!1,t.updates.queueChecker(),t.updates.requestForCredentialsModalClose()}),d.on("click",'[data-js-action="close"], .notification-dialog-background',t.updates.requestForCredentialsModalCancel),i.on("change",'input[name="connection_type"]',function(){e("#ssh-keys").toggleClass("hidden","ssh"!==e(this).val())}).change(),s.on("credential-modal-cancel",function(a,s){var n,l,i=e(".updating-message");"import"===pagenow?i.removeClass("updating-message"):"plugins"===pagenow||"plugins-network"===pagenow?"update-plugin"===s.action?n=e('tr[data-plugin="'+s.data.plugin+'"]').find(".update-message"):"delete-plugin"===s.action&&(n=e('[data-plugin="'+s.data.plugin+'"]').find(".row-actions a.delete")):"themes"===pagenow||"themes-network"===pagenow?"update-theme"===s.action?n=e('[data-slug="'+s.data.slug+'"]').find(".update-message"):"delete-theme"===s.action&&"themes-network"===pagenow?n=e('[data-slug="'+s.data.slug+'"]').find(".row-actions a.delete"):"delete-theme"===s.action&&"themes"===pagenow&&(n=e(".theme-actions .delete-theme")):n=i,n&&n.hasClass("updating-message")&&(void 0===(l=n.data("originaltext"))&&(l=e("<p>").html(n.find("p").data("originaltext"))),n.removeClass("updating-message").html(l),"plugin-install"!==pagenow&&"plugin-install-network"!==pagenow||("update-plugin"===s.action?n.attr("aria-label",t.updates.l10n.pluginUpdateNowLabel.replace("%s",n.data("name"))):"install-plugin"===s.action&&n.attr("aria-label",t.updates.l10n.pluginInstallNowLabel.replace("%s",n.data("name"))))),t.a11y.speak(t.updates.l10n.updateCancel,"polite")}),l.on("click","[data-plugin] .update-link",function(a){var s=e(a.target),n=s.parents("tr");a.preventDefault(),s.hasClass("updating-message")||s.hasClass("button-disabled")||(t.updates.maybeRequestFilesystemCredentials(a),t.updates.$elToReturnFocusToFromCredentialsModal=n.find(".check-column input"),t.updates.updatePlugin({plugin:n.data("plugin"),slug:n.data("slug")}))}),n.on("click",".update-now",function(a){var s=e(a.target);a.preventDefault(),s.hasClass("updating-message")||s.hasClass("button-disabled")||(t.updates.maybeRequestFilesystemCredentials(a),t.updates.updatePlugin({plugin:s.data("plugin"),slug:s.data("slug")}))}),n.on("click",".install-now",function(a){var n=e(a.target);a.preventDefault(),n.hasClass("updating-message")||n.hasClass("button-disabled")||(t.updates.shouldRequestFilesystemCredentials&&!t.updates.ajaxLocked&&(t.updates.requestFilesystemCredentials(a),s.on("credential-modal-cancel",function(){e(".install-now.updating-message").removeClass("updating-message").text(t.updates.l10n.installNow),t.a11y.speak(t.updates.l10n.updateCancel,"polite")})),t.updates.installPlugin({slug:n.data("slug")}))}),s.on("click",".importer-item .install-now",function(a){var n=e(a.target),l=e(this).data("name");a.preventDefault(),n.hasClass("updating-message")||(t.updates.shouldRequestFilesystemCredentials&&!t.updates.ajaxLocked&&(t.updates.requestFilesystemCredentials(a),s.on("credential-modal-cancel",function(){n.removeClass("updating-message").text(t.updates.l10n.installNow).attr("aria-label",t.updates.l10n.pluginInstallNowLabel.replace("%s",l)),t.a11y.speak(t.updates.l10n.updateCancel,"polite")})),t.updates.installPlugin({slug:n.data("slug"),pagenow:pagenow,success:t.updates.installImporterSuccess,error:t.updates.installImporterError}))}),l.on("click","[data-plugin] a.delete",function(a){var s=e(a.target).parents("tr");a.preventDefault(),window.confirm(t.updates.l10n.aysDeleteUninstall.replace("%s",s.find(".plugin-title strong").text()))&&(t.updates.maybeRequestFilesystemCredentials(a),t.updates.deletePlugin({plugin:s.data("plugin"),slug:s.data("slug")}))}),s.on("click",".themes-php.network-admin .update-link",function(a){var s=e(a.target),n=s.parents("tr");a.preventDefault(),s.hasClass("updating-message")||s.hasClass("button-disabled")||(t.updates.maybeRequestFilesystemCredentials(a),t.updates.$elToReturnFocusToFromCredentialsModal=n.find(".check-column input"),t.updates.updateTheme({slug:n.data("slug")}))}),s.on("click",".themes-php.network-admin a.delete",function(a){var s=e(a.target).parents("tr");a.preventDefault(),window.confirm(t.updates.l10n.aysDelete.replace("%s",s.find(".theme-title strong").text()))&&(t.updates.maybeRequestFilesystemCredentials(a),t.updates.deleteTheme({slug:s.data("slug")}))}),l.on("click",'[type="submit"]:not([name="clear-recent-list"])',function(a){var n,i,d=e(a.target).siblings("select").val(),u=l.find('input[name="checked[]"]:checked'),r=0,o=0,p=[];switch(pagenow){case"plugins":case"plugins-network":n="plugin";break;case"themes-network":n="theme";break;default:return}if(!u.length)return a.preventDefault(),e("html, body").animate({scrollTop:0}),t.updates.addAdminNotice({id:"no-items-selected",className:"notice-error is-dismissible",message:t.updates.l10n.noItemsSelected});switch(d){case"update-selected":i=d.replace("selected",n);break;case"delete-selected":if(!window.confirm("plugin"===n?t.updates.l10n.aysBulkDelete:t.updates.l10n.aysBulkDeleteThemes))return void a.preventDefault();i=d.replace("selected",n);break;default:return}t.updates.maybeRequestFilesystemCredentials(a),a.preventDefault(),l.find('.manage-column [type="checkbox"]').prop("checked",!1),s.trigger("wp-"+n+"-bulk-"+d,u),u.each(function(a,s){var n=e(s),l=n.parents("tr");"update-selected"!==d||l.hasClass("update")&&!l.find("notice-error").length?t.updates.queue.push({action:i,data:{plugin:l.data("plugin"),slug:l.data("slug")}}):n.prop("checked",!1)}),s.on("wp-plugin-update-success wp-plugin-update-error wp-theme-update-success wp-theme-update-error",function(a,s){var n,l,i=e('[data-slug="'+s.slug+'"]');"wp-"+s.update+"-update-success"===a.type?r++:(l=s.pluginName?s.pluginName:i.find(".column-primary strong").text(),o++,p.push(l+": "+s.errorMessage)),i.find('input[name="checked[]"]:checked').prop("checked",!1),t.updates.adminNotice=t.template("wp-bulk-updates-admin-notice"),t.updates.addAdminNotice({id:"bulk-action-notice",className:"bulk-action-notice",successes:r,errors:o,errorMessages:p,type:s.update}),n=e("#bulk-action-notice").on("click","button",function(){e(this).toggleClass("bulk-action-errors-collapsed").attr("aria-expanded",!e(this).hasClass("bulk-action-errors-collapsed")),n.find(".bulk-action-errors").toggleClass("hidden")}),o>0&&!t.updates.queue.length&&e("html, body").animate({scrollTop:0})}),s.on("wp-updates-notice-added",function(){t.updates.adminNotice=t.template("wp-updates-admin-notice")}),t.updates.queueChecker()}),r.length&&r.attr("aria-describedby","live-search-desc"),r.on("keyup input",_.debounce(function(a,s){var l,i,d=e(".plugin-install-search");l={_ajax_nonce:t.updates.ajaxNonce,s:a.target.value,tab:"search",type:e("#typeselector").val(),pagenow:pagenow},i=location.href.split("?")[0]+"?"+e.param(_.omit(l,["_ajax_nonce","pagenow"])),"keyup"===a.type&&27===a.which&&(a.target.value=""),t.updates.searchTerm===l.s&&"typechange"!==s||(n.empty(),t.updates.searchTerm=l.s,
window.history&&window.history.replaceState&&window.history.replaceState(null,"",i),d.length||(d=e('<li class="plugin-install-search" />').append(e("<a />",{class:"current",href:i,text:t.updates.l10n.searchResultsLabel})),e(".wp-filter .filter-links .current").removeClass("current").parents(".filter-links").prepend(d),n.prev("p").remove(),e(".plugins-popular-tags-wrapper").remove()),void 0!==t.updates.searchRequest&&t.updates.searchRequest.abort(),e("body").addClass("loading-content"),t.updates.searchRequest=t.ajax.post("search-install-plugins",l).done(function(a){e("body").removeClass("loading-content"),n.append(a.items),delete t.updates.searchRequest,0===a.count?t.a11y.speak(t.updates.l10n.noPluginsFound):t.a11y.speak(t.updates.l10n.pluginsFound.replace("%d",a.count))}))},500)),u.length&&u.attr("aria-describedby","live-search-desc"),u.on("keyup input",_.debounce(function(a){var s,n={_ajax_nonce:t.updates.ajaxNonce,s:a.target.value,pagenow:pagenow,plugin_status:"all"};"keyup"===a.type&&27===a.which&&(a.target.value=""),t.updates.searchTerm!==n.s&&(t.updates.searchTerm=n.s,s=_.object(_.compact(_.map(location.search.slice(1).split("&"),function(e){if(e)return e.split("=")}))),n.plugin_status=s.plugin_status||"all",window.history&&window.history.replaceState&&window.history.replaceState(null,"",location.href.split("?")[0]+"?s="+n.s+"&plugin_status="+n.plugin_status),void 0!==t.updates.searchRequest&&t.updates.searchRequest.abort(),l.empty(),e("body").addClass("loading-content"),e(".subsubsub .current").removeClass("current"),t.updates.searchRequest=t.ajax.post("search-plugins",n).done(function(a){var s=e("<span />").addClass("subtitle").html(t.updates.l10n.searchResults.replace("%s",_.escape(n.s))),i=e(".wrap .subtitle");n.s.length?i.length?i.replaceWith(s):e(".wp-header-end").before(s):(i.remove(),e(".subsubsub ."+n.plugin_status+" a").addClass("current")),e("body").removeClass("loading-content"),l.append(a.items),delete t.updates.searchRequest,0===a.count?t.a11y.speak(t.updates.l10n.noPluginsFound):t.a11y.speak(t.updates.l10n.pluginsFound.replace("%d",a.count))}))},500)),s.on("submit",".search-plugins",function(t){t.preventDefault(),e("input.wp-filter-search").trigger("input")}),s.on("click",".try-again",function(e){e.preventDefault(),r.trigger("input")}),e("#typeselector").on("change",function(){var t=e('input[name="s"]');t.val().length&&t.trigger("input","typechange")}),e("#plugin_update_from_iframe").on("click",function(t){var a,s=window.parent===window?null:window.parent;e.support.postMessage=!!window.postMessage,!1!==e.support.postMessage&&null!==s&&-1===window.parent.location.pathname.indexOf("update-core.php")&&(t.preventDefault(),a={action:"update-plugin",data:{plugin:e(this).data("plugin"),slug:e(this).data("slug")}},s.postMessage(JSON.stringify(a),window.location.origin))}),e("#plugin_install_from_iframe").on("click",function(t){var a,s=window.parent===window?null:window.parent;e.support.postMessage=!!window.postMessage,!1!==e.support.postMessage&&null!==s&&-1===window.parent.location.pathname.indexOf("index.php")&&(t.preventDefault(),a={action:"install-plugin",data:{slug:e(this).data("slug")}},s.postMessage(JSON.stringify(a),window.location.origin))}),e(window).on("message",function(a){var s,n=a.originalEvent,l=document.location.protocol+"//"+document.location.hostname;if(n.origin===l){try{s=e.parseJSON(n.data)}catch(e){return}if(s&&void 0!==s.action)switch(s.action){case"decrementUpdateCount":t.updates.decrementCount(s.upgradeType);break;case"install-plugin":case"update-plugin":window.tb_remove(),s.data=t.updates._addCallbacks(s.data,s.action),t.updates.queue.push(s),t.updates.queueChecker()}}}),e(window).on("beforeunload",t.updates.beforeunload)})}(jQuery,window.wp,window._wpUpdatesSettings);