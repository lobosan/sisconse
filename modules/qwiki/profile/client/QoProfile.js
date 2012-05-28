/*
 * qWikiOffice Desktop 1.0
 * Copyright(c) 2007-2010, Murdock Technologies, Inc.
 * licensing@qwikioffice.com
 *
 * http://www.qwikioffice.com/license
 */

QoDesk.QoProfile = Ext.extend(Ext.app.Module, {
   /**
    * Read only.
    * @type {String}
    */
   id: 'qo-profile'
   /**
    * Read only.
    * @type {String}
    */
   , type: 'user/profile'
   /**
    * Read only.
    * @type {Object}
    */
   , locale: null
   /**
    * Read only.
    * @type {Ext.Window}
    */
   , win: null
   /**
    * Read only.
    * @type {String}
    */
   , errorIconCls : 'x-status-error'

   , init : function(){
   	this.locale = QoDesk.QoProfile.Locale;
	}

   , createWindow : function(){
      var d = this.app.getDesktop();
      this.win = d.getWindow(this.id);

      var h = parseInt(d.getWinHeight() * 0.9);
      var w = parseInt(d.getWinWidth() * 0.9);
      if(h > 260){h = 280;}
      if(w > 310){w = 410;}

      if(this.win){
         this.win.setSize(w, h);
      }else{
         this.profilePanel = new Ext.FormPanel ({
            border: false
            , buttons: [
               {
                  handler: this.onSaveProfile
                  , scope: this
                  , text: 'Guardar'
                  , type: 'submit'
               }
               //, { handler: this.onCancel, scope: this, text: 'Cancel' }
            ]
            , buttonAlign: 'right'
            , disabled: this.app.isAllowedTo('saveProfile', this.id) ? false : true
            , items: [
               {
                  autoEl: {
                     tag: 'div'
                     , html: 'Utilice este formulario para actualizar la información de su perfil.'
                     , style: 'font-weight:bold; padding:0 0 20px 0;'
                  }
                  , xtype: 'box'
               }
               , {
                  allowBlank: false
                  , anchor: '100%'
                  , fieldLabel: 'Nombre'
                  , listeners: {
                     'invalid': { buffer: 250, fn: this.onInValid, scope: this }
                     , 'valid': { buffer: 250, fn: this.onValid, scope: this }
                  }
                  , name: 'field1'
                  , xtype: 'textfield'
               }
               , {
                  allowBlank: false
                  , anchor: '100%'
                  , fieldLabel: 'Apellido'
                  , listeners: {
                     'invalid': { buffer: 250, fn: this.onInValid, scope: this }
                     , 'valid': { buffer: 250, fn: this.onValid, scope: this }
                  }
                  , name: 'field2'
                  , xtype: 'textfield'
               }
               , {
                  allowBlank: false
                  , anchor: '100%'
                  , fieldLabel: 'Email'
                  , listeners: {
                     'invalid': { buffer: 250, fn: this.onInValid, scope: this }
                     , 'valid': { buffer: 250, fn: this.onValid, scope: this }
                  }
                  , name: 'field3'
                  , vtype: 'email'
                  , xtype: 'textfield'
               }
            ]
            , labelWidth: 60
            , title: 'Perfil'
            , url: this.app.connection
         });

         this.passwordPanel = new Ext.FormPanel({
            border: false
            , buttons: [
               {
                  handler: this.onSavePassword
                  , scope: this
                  , text: 'Guardar'
                  , type: 'submit'
               }
               //, { handler: this.onCancel, scope: this, text: 'Cancel' }
            ]
            , buttonAlign: 'right'
            , disabled: this.app.isAllowedTo('savePwd', this.id) ? false : true
            , items: [
               {
                  autoEl: {
                     tag: 'div'
                     , html: 'Utilice este formulario para actualizar su contraseña.'
                     , style: 'font-weight:bold; padding:0 0 20px 0;'
                  }
                  , xtype: 'box'
               }
               , {
                  allowBlank: false
                  , anchor: '100%'
                  , fieldLabel: 'Contraseña'
                  , inputType: 'password'
                  , listeners: {
                     'invalid': { buffer: 250, fn: this.onInValid, scope: this }
                     , 'valid': { buffer: 250, fn: this.onValid, scope: this }
                  }
                  , name: 'field1'
                  , validator: this.passwordValidator.createDelegate(this)
                  , xtype: 'textfield'
               }
               , {
                  allowBlank: false
                  , anchor: '100%'
                  , fieldLabel: 'Confirmar contraseña'
                  , inputType: 'password'
                  , listeners: {
                     'invalid': { buffer: 250, fn: this.onInValid, scope: this }
                     , 'valid': { buffer: 250, fn: this.onValid, scope: this }
                  }
                  , name: 'field2'
                  , validator: this.passwordValidator.createDelegate(this)
                  , xtype: 'textfield'
               }
            ]
            , labelWidth: 125
            , title: 'Contraseña'
            , url: this.app.connection
         });

         this.tabPanel = new Ext.TabPanel({
            activeTab: 0
            , border: false
            , defaults: {bodyStyle: 'padding:10px'}
            , items: [
               this.profilePanel
               , this.passwordPanel
            ]
            , listeners: {
               'tabchange': {fn: this.onTabChange, scope: this}
            }
            , xtype: 'tabpanel'
         });

         this.statusbar = new Ext.ux.StatusBar({
            defaultText: 'Listo'
         });

         this.win = d.createWindow({
            animCollapse: false
            , bbar: this.statusbar
            , constrainHeader: true
            , id: this.id
            , height: h
            , iconCls: 'qo-profile-icon'
            , items: this.tabPanel
            , layout: 'fit'
            , shim: false
            , taskbuttonTooltip: this.locale.launcherTooltip
            , title: this.locale.windowTitle
            , width: w
         });
      }
      // show the window
      this.win.show();
      // load the profile form
      this.profilePanel.getForm().load({
         params:{
            method: 'loadProfile'
            , moduleId: this.id
         }
      });
   }

   //, onCancel : function(){
   //   this.win.close();
   //}

   , onSaveProfile : function(){
      this.showMask();
      this.statusbar.showBusy('Guardando perfil...');
      this.profilePanel.getForm().submit({
         failure: function(r,o){
            this.hideMask();
            alert('No se puede guardar su perfil');
         }
         , params: {
            method: 'saveProfile'
            , moduleId: this.id
         }
         , scope: this
         , success: function(form, action){
            this.hideMask();
            this.statusbar.setStatus({clear: true, iconCls: '', text: 'Perfil guardado!'});
         }
      });
   }

   , onSavePassword : function(){
      this.showMask();
      this.statusbar.showBusy('Guardando contraseña...');
      this.passwordPanel.getForm().submit({
         failure: function(r,o){
            this.hideMask();
            alert('No se puede guardar su contraseña');
         }
         , params: {
            method: 'savePwd'
            , moduleId: this.id
         }
         , scope: this
         , success: function(form, action){
            this.hideMask();
            this.statusbar.setStatus({clear: true, iconCls: '', text: 'Contraseña guardada!'});
         }
      });
   }

   , passwordValidator : function(){
      var f = this.passwordPanel.getForm();
      var o = f.getValues();
      var p1 = o.field1.trim();
      var p2 = o.field2.trim();
      var msg = 'Se requiere que las contraseñas sean iguales!';
      if(p1 === '' && p2 === ''){
         f.markInvalid();
         return msg;
      }else if(p1 === p2){
         f.clearInvalid();
         return true;
      }
      return msg;
   }

   /**
    * @param {Ext.TabPanel} tabPanel
    * @param {Ext.FormPanel} panel
    */
   , onTabChange : function(tabPanel, panel){
      if(panel.getForm().isValid()){
         this.onValid();
      }else{
         this.onInValid();
      }
   }

   , onInValid : function(){
      this.tabPanel.getActiveTab().buttons[0].disable();
      this.statusbar.setStatus({iconCls: this.errorIconCls, text: 'Por favor, revise sus datos.'});
   }

   , onValid : function(){
      this.tabPanel.getActiveTab().buttons[0].enable();
      this.statusbar.setStatus({iconCls: '', text: 'Listo'});
   }

   , showMask : function(){
      this.win.body.mask();
   }

   , hideMask : function(){
      this.win.body.unmask();
   }
});