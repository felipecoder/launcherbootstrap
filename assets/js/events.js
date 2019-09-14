function getEvents(element, events) {

  var onReady = [];
  var eventsTime = events;

  function toSeconds(h, m, s) {
    return h * 3600 + m * 60 + s;
  }

  function updateEventsTime() {
    var d = new Date();
    var time = toSeconds(d.getHours(), d.getMinutes(), d.getSeconds());

    var html = '';
    for (i in eventsTime) {
      var j;
      for (j = 0; j < eventsTime[i][1].length; j++) {
        var t = eventsTime[i][1][j].split(':');
        t = toSeconds(t[0], t[1], 0);
        if (t > time) break;
      }

      j = j % eventsTime[i][1].length;
      var t = eventsTime[i][1][j].split(':');

      var diff = toSeconds(t[0], t[1], 0) - time;
      if (diff < 0) diff += 3600 * 24;

      var c = "label-primary";
      if (diff < 15 * 60) c = "label-success";

      var h = parseInt(diff / 3600);
      diff -= 3600 * h;
      var m = parseInt(diff / 60);
      var s = diff - m * 60;

      var countdown = h + ':' + ("0" + m).slice(-2) + ':' + ("0" + s).slice(-2);

      //Eventos contando //
      html += '<li>' + eventsTime[i][0] + ': <span class="label label-primary ' + c + '">' + countdown + '</span></li>';

    }
    $(element).html(html);
  }

  onReady.push(function () { setInterval(updateEventsTime, 1000) });

  for (var i in onReady) onReady[i]();
}