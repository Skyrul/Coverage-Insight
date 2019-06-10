                // Muaz Khan     - https://github.com/muaz-khan
                // MIT License   - https://www.webrtc-experiment.com/licence/
                // Documentation - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/video-conferencing
                var config = {
                    // via: https://github.com/muaz-khan/WebRTC-Experiment/tree/master/socketio-over-nodejs
                    openSocket: function(config) {
                        var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';
                        config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                        var sender = Math.round(Math.random() * 999999999) + 999999999;
                        io.connect(SIGNALING_SERVER).emit('new-channel', {
                            channel: config.channel,
                            sender: sender
                        });
                        var socket = io.connect(SIGNALING_SERVER + config.channel);
                        socket.channel = config.channel;
                        socket.on('connect', function () {
                            if (config.callback) config.callback(socket);
                        });
                        socket.send = function (message) {
                            socket.emit('message', {
                                sender: sender,
                                data: message
                            });
                        };
                        socket.on('message', config.onmessage);
                    },
                    onRemoteStream: function(media) {
                        var mediaElement = getMediaElement(media.video, {
                            width: (videosContainer.clientWidth / 2) - 50,
                            buttons: ['mute-audio', 'mute-video', 'full-screen', 'volume-slider']
                        });
                        mediaElement.id = media.stream.streamid;
                        videosContainer.appendChild(mediaElement);
                    },
                    onRemoteStreamEnded: function(stream, video) {
                        if (video.parentNode && video.parentNode.parentNode && video.parentNode.parentNode.parentNode) {
                            video.parentNode.parentNode.parentNode.removeChild(video.parentNode.parentNode);
                        }
                    },
                    onRoomFound: function(room) {
                        var alreadyExist = document.querySelector('button[data-broadcaster="' + room.broadcaster + '"]');
                        if (alreadyExist) return;
                        if (typeof roomsList === 'undefined') roomsList = document.body;
                        var tr = document.createElement('tr');
                        tr.innerHTML = '<td><strong>' + room.roomName + '</strong> shared a conferencing room with you!</td>' +
                            '<td><button class="join">Join</button></td>';
                        roomsList.appendChild(tr);
                        var joinRoomButton = tr.querySelector('.join');
                        joinRoomButton.setAttribute('data-broadcaster', room.broadcaster);
                        joinRoomButton.setAttribute('data-roomToken', room.roomToken);
                        joinRoomButton.onclick = function() {
                            this.disabled = true;
                            var broadcaster = this.getAttribute('data-broadcaster');
                            var roomToken = this.getAttribute('data-roomToken');
                            captureUserMedia(function() {
                                conferenceUI.joinRoom({
                                    roomToken: roomToken,
                                    joinUser: broadcaster
                                });
                            }, function() {
                                joinRoomButton.disabled = false;
                            });
                        };
                    },
                    onRoomClosed: function(room) {
                        var joinButton = document.querySelector('button[data-roomToken="' + room.roomToken + '"]');
                        if (joinButton) {
                            // joinButton.parentNode === <li>
                            // joinButton.parentNode.parentNode === <td>
                            // joinButton.parentNode.parentNode.parentNode === <tr>
                            // joinButton.parentNode.parentNode.parentNode.parentNode === <table>
                            joinButton.parentNode.parentNode.parentNode.parentNode.removeChild(joinButton.parentNode.parentNode.parentNode);
                        }
                    },
                    onReady: function() {
                        console.log('now you can open or join rooms');
                    }
                };
                function setupNewRoomButtonClickHandler() {
                    btnSetupNewRoom.disabled = true;
                    // document.getElementById('conference-name').disabled = true;
                    captureUserMedia(function() {
                        conferenceUI.createRoom({
                            roomName: (document.getElementById('conference-name') || { }).value || 'Anonymous'
                        });
                    }, function() {
                        btnSetupNewRoom.disabled = document.getElementById('conference-name').disabled = false;
                    });
                }
                function captureUserMedia(callback, failure_callback) {
                    $('#stream1').remove();
                    var video = document.createElement('video');
                    video.id = 'stream1';
                    video.class = 'stream1'
                    video.muted = true;
                    video.volume = 0;
                    try {
                        video.setAttributeNode(document.createAttribute('autoplay'));
                        video.setAttributeNode(document.createAttribute('playsinline'));
                        video.setAttributeNode(document.createAttribute('controls'));
                    } catch (e) {
                        video.setAttribute('autoplay', true);
                        video.setAttribute('playsinline', true);
                        video.setAttribute('controls', true);
                    }
                    getUserMedia({
                        video: video,
                        onsuccess: function(stream) {
                            config.attachStream = stream;
                            var mediaElement = getMediaElement(video, {
                                width: (videosContainer.clientWidth / 2) - 50,
                                buttons: ['mute-audio', 'mute-video', 'full-screen', 'volume-slider']
                            });
                            mediaElement.toggle('mute-audio');
                            videosContainer.appendChild(mediaElement);
                            callback && callback();
                        },
                        onerror: function() {
                            alert('unable to get access to your webcam');
                            callback && callback();
                        }
                    });
                }
                var conferenceUI = conference(config);
                /* UI specific */
                var videosContainer = document.getElementById('videos-container'); // modified
                var btnSetupNewRoom = document.getElementById('vidbtn-video');  //modified
                // var videosContainer = document.getElementById('videos-container') || document.body;
                // var btnSetupNewRoom = document.getElementById('setup-new-room');
                var roomsList = document.getElementById('rooms-list');
                if (btnSetupNewRoom) btnSetupNewRoom.onclick = setupNewRoomButtonClickHandler;
                function rotateVideo(video) {
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                    setTimeout(function() {
                        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                    }, 1000);
                }
                (function() {
                    var uniqueToken = document.getElementById('unique-token');
                    if (uniqueToken)
                        if (location.hash.length > 2) uniqueToken.parentNode.parentNode.parentNode.innerHTML = '<h2 style="text-align:center;display: block;"><a href="' + location.href + '" target="_blank">Right click to copy & share this private link</a></h2>';
                        else uniqueToken.innerHTML = uniqueToken.parentNode.parentNode.href = '#' + (Math.random() * new Date().getTime()).toString(36).toUpperCase().replace( /\./g , '-');
                })();
                function scaleVideos() {
                    var videos = document.querySelectorAll('video'),
                        length = videos.length, video;
                    var minus = 130;
                    var windowHeight = 700;
                    var windowWidth = 600;
                    var windowAspectRatio = windowWidth / windowHeight;
                    var videoAspectRatio = 4 / 3;
                    var blockAspectRatio;
                    var tempVideoWidth = 0;
                    var maxVideoWidth = 0;
                    for (var i = length; i > 0; i--) {
                        blockAspectRatio = i * videoAspectRatio / Math.ceil(length / i);
                        if (blockAspectRatio <= windowAspectRatio) {
                            tempVideoWidth = videoAspectRatio * windowHeight / Math.ceil(length / i);
                        } else {
                            tempVideoWidth = windowWidth / i;
                        }
                        if (tempVideoWidth > maxVideoWidth)
                            maxVideoWidth = tempVideoWidth;
                    }
                    for (var i = 0; i < length; i++) {
                        video = videos[i];
                        if (video)
                            video.width = maxVideoWidth - minus;
                    }
                }
                window.onresize = scaleVideos;

// Main entry
(function() {
    console.log('agency view loaded');

    window.onload = function() {
        store.set('audio', false);
        store.set('video', false);
        store.set('screenshare', false);
    }

    // Events
    $('#vidbtn-audio').on('click', function(e) {
        var s = store.get('audio');
        if (!s) {
            $(this).addClass('vid-btns-selected');
            $(this).find('span').text('Turn-Off Call');
            store.set('audio', true);

            startCallWebRTC();
        } else {
            $(this).removeClass('vid-btns-selected');
            $(this).find('span').text('Call');
            store.set('audio', false);
        }
    });
    $('#vidbtn-video').on('click', function(e) {
        var s = store.get('video');
        if (!s) {
            $('#videostream').attr('class', 'col-md-11 form');
            $('#customerinfo').attr('class', 'col-md-offset-1 col-md-6 customer-info-bottom');
            $('.stream3').removeClass('hide');
            $(this).addClass('vid-btns-selected');
            $(this).find('span').text('Turn-Off Video');
            store.set('video', true);
        } else {
            $('#videostream').attr('class', 'col-md-6');
            $('#customerinfo').attr('class', 'col-md-4');
            $('.stream3').addClass('hide');
            $(this).removeClass('vid-btns-selected');
            $(this).find('span').text('Video');
            store.set('video', false);
        }
    });

    $('#vidbtn-screen-share').on('click', function(e) {
        var s = store.get('screenshare');
        if (!s) {
            $('#videostream').attr('class', 'col-md-11 form');
            $('#customerinfo').attr('class', 'col-md-offset-1 col-md-6 customer-info-bottom');
            $('.desktopshare-img').removeClass('hide');
            $(this).addClass('vid-btns-selected');
            $(this).find('span').text('Turn-Off Share');
            store.set('screenshare', true);
        } else {
            $('#videostream').attr('class', 'col-md-6');
            $('#customerinfo').attr('class', 'col-md-4');
            $('.desktopshare-img').addClass('hide');
            $(this).removeClass('vid-btns-selected');
            $(this).find('span').text('Share Screen');
            store.set('screenshare', false);
        }
    });
    
})();