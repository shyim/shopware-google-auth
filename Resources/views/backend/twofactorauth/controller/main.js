Ext.define('Shopware.apps.Twofactorauth.controller.Main', {
    extend: 'Ext.app.Controller',

    init: function() {
        var me = this;

        this.mainWindow = this.getView('Main').create({}).show();
    }
});
