angular.module('cultstage')
.controller('ScriptCtrl', function ($http, Notification) {
  var t=this;
  t.newscript=false;
  t.allscripts=[];
  t.init=function() {
    $http.get('/myscripts')
    .success(function (resp) {
      t.allscripts=resp;
      console.log(resp);
    })
    .error(function(resp) {
      Notification.error({message: 'Error getting your scripts.', replaceMessage: true});
    });
  }
  t.cancel=function () {
      t.newscript=false;
      t.data={};
  }
    t.delete=function(item) {
      $http.get('/delete_script/'+item.id)
      .success(function(resp) {
        t.allscripts.splice(t.allscripts.indexOf(item), 1);
      })
      .error(function(resp) {
        console.log('error deleting script');
      });
    }
  t.update=function (script,index) {
    if(script.title && script.script){
      $http.post('/updatescript',script)
      .success(function(resp) {
        t.allscripts[index]=script;
        Notification.success({message: 'Script successfully updated.', replaceMessage: true});
        t.editscript[index]=false;
      })
      .error(function() {
        Notification.error({message: 'Error updating your script.', replaceMessage: true});
      });
    }
  }
  t.save=function () {
    if(t.data.title && t.data.script){
      $http.post('/savescript',t.data)
      .success(function(resp) {
        t.allscripts.unshift(resp);
        Notification.success({message: 'Script successfully saved.', replaceMessage: true});
        t.cancel();
      })
      .error(function() {
        Notification.error({message: 'Error saving your script.', replaceMessage: true});
      });
    }
  }
})
