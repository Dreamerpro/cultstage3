angular.module('cultstage')
.controller('AudioController', function ($http, Notification,Upload) {
  var _self=this;
  this.init=function() {
  _self.loaded=false;
  _self.audios=[];
    $http.get('/uploaded/audios')
    .success(function(msg) {
      console.log(msg);
      _self.loaded=true;
      _self.audios=msg;
    })
    .error(function(msg) {
      console.log(msg);
      _self.loaded=true;
    })
  }
  this.delete=function(item, index) {
    $http.get('/delete/audio/'+item.name)
    .success(function(dt) {   _self.audios.splice(index,1);   })
    .error(function(as) {     console.log(as);Notification.error({message:'Error deleting audio!',replaceMessage:true})   })
  }
  this.upload=function(file) {
    Upload.upload({
        url: '/upload/audio',
        data: {file: file}
    }).then(function (resp) {

        console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.config.data);
        Notification.success('Successfully uploaded  video.');
        _self.init();

    }, function (resp) {
        Notification.error('Error uploading video.');
    }, function (evt) {
        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
        _self.uploadPercentage=progressPercentage;
        if(_self.uploadPercentage==100){_self.uploadPercentage=0;}
        console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
    });

  }
})
