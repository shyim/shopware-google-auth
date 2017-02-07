Ext.define('Shopware.apps.Twofactorauth.view.Main', {
    extend: 'Ext.window.Window',
    width: 400,
    height: 380,
    resizable: false,
    maximizable: false,
    plain: true,
    title: 'Two factor authentication',
    layout: {
        type: 'vbox',
        align : 'stretch',
        pack  : 'start'
    },

    initComponent: function() {
        var me = this;

        me.items = [
            {
                xtype: 'container',
                html: '<div style="text-align: center">\n<img style="margin-top: 5px; margin-bottom: 5px;" src="{$qrCode}"><br>\n<p>Get Google Authentificator from Store</p>\n    <div style="display: flex; justify-content: center">\n<a target="_blank" style="display: inline-block; float: left" href=\'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&utm_source=global_co&utm_medium=prtnr&utm_content=Mar2515&utm_campaign=PartBadge&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1\'>\n    <img width="165" alt=\'Get it on Google Play\' src=\'https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png\'/>\n</a>\n<a target="_blank" href="https://itunes.apple.com/de/app/google-authenticator/id388497605?mt=8" style="float: left;margin-top: 10px;display: inline-block;overflow:hidden;background:url(https://linkmaker.itunes.apple.com/images/badges/en-us/badge_appstore-lrg.svg) no-repeat;width:165px;height:40px;"></a>\n    </div>\n</div>',
                flex: 5
            },
            {
                xtype: 'button',
                text: 'Activate',
                cls: 'btn primary',
                anchor: '100%',
                handler: function () {
                    Ext.Ajax.request({
                        url: '{url action=enable}',
                        params: {
                            secret: '{$secret}'
                        },
                        success: function(response){
                            Shopware.Notification.createGrowlMessage("Two Factor Auth", "Authentification is enabled");
                        }
                    });
                }
            }
        ];

        me.callParent();

        Ext.EventManager.onWindowResize(function() { me.center(); })
    }
});
