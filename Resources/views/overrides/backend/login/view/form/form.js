//{block name="backend/login/view/main/form" append}
Ext.override(Shopware.apps.Login.view.main.Form, {
    initComponent: function () {
        var me = this;

        me.callParent(arguments);

        me.items.insert(3, Ext.create('Ext.form.field.Text', {
            name: 'code',
            allowBlank: true,
            emptyText: 'Google Authentificator Code'
        }));
    }
});
//{/block}