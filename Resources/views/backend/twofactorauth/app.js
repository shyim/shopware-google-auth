Ext.define('Shopware.apps.Twofactorauth', {
    name: 'Shopware.apps.Twofactorauth',
    extend: 'Enlight.app.SubApplication',
    loadPath: '{url action=load}',
    bulkLoad: true,
    controllers: [ 'Main' ],
    stores: [],
    models: [],
    views: [ 'Main' ],
    targetName: 'Shopware.apps.Index',

    launch: function() {
        var me = this,
            mainController = me.getController('Main');

        return mainController.mainWindow;
    }
});
