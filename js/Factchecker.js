class Factchecker {
    constructor(videoId, facts) {
        this.videoId = videoId;
        this.facts = facts;
        this.player = null;
        this.checkArea = document.getElementById('checkArea');
        this.currentFacts = [];
        this.loadYoutubeIframeAPI();
        window.onYouTubeIframeAPIReady = this.onYouTubeIframeAPIReady.bind(this);
    }

    loadYoutubeIframeAPI() {
        let tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }

    onYouTubeIframeAPIReady() {
        this.player = new YT.Player('player', {
          height: '390',
          width: '640',
          videoId: this.videoId,
          events: {
            'onReady': this.onPlayerReady.bind(this),
            'onStateChange': this.onPlayerStateChange.bind(this)
          }
        });
    }

    onPlayerReady(event) {
        console.log("Player Ready");
    }

    onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.PLAYING) {
            this.updateFacts(true);
            this.factInterval = setInterval(this.updateFacts.bind(this), 1000);
        } else {
            clearInterval(this.factInterval);
        }
    }

    updateFacts(clear = false) {
        let currentTime = Math.floor(this.player.getCurrentTime()) * 1000; // Convert to milliseconds
        if (clear)
            this.clearFacts();
        let factsLength = this.facts.length;
        console.log("Facts length: " + factsLength);
        let factCache = [];
        for (let i = 0; i < factsLength; i++) {
            let fact = this.facts[i];
            if (i < factsLength - 1 && this.facts[i + 1].video_timestamp_end - fact.video_timestamp_end == 1) {
                factCache.push(fact);
            }
            else {
                if (factCache.length > 0) {
                    let addedFactCache = "";
                    fact.video_timestamp_end = factCache[0].video_timestamp_end;
                    factCache.forEach(factCacheItem => {
                        addedFactCache += factCacheItem.comment + " ";
                        this.facts = this.facts.filter(value => value !== factCacheItem);
                        factsLength--;
                    });
                    fact.comment = addedFactCache + fact.comment;
                    factCache = [];
                }
    
                if ((currentTime >= fact.video_timestamp_end && currentTime < fact.video_timestamp_end + 1000) || (currentTime >= fact.video_timestamp_end && clear)) {
                    this.showFact(fact.name, fact.comment, fact.picture);
                    this.currentFacts.push(fact);
                }
            }
        }
    }

    clearFacts() {
        this.checkArea.innerHTML = '';
        this.currentFacts = [];
    }

    showFact(type, text, personPicture) {
        let accountProfilePicture = document.createElement('img');
        accountProfilePicture.src = '../images/' + type + '.png';

        if (personPicture) {
            accountProfilePicture.src = 'data:image/jpeg;base64,' + personPicture;
        }

        let comment = document.createElement('span');

        // Detect links in the text and convert them to <a> elements
        let linkRegex = /(https?:\/\/[^\s]+)/g;
        let parts = text.split(linkRegex);
        parts.forEach(part => {
            if (linkRegex.test(part)) {
                let link = document.createElement('a');
                link.href = part;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                link.innerText = part;
                comment.appendChild(link);
            } else {
                comment.appendChild(document.createTextNode(part));
            }
        });

        let fact = document.createElement('div');
        fact.appendChild(accountProfilePicture);
        fact.appendChild(comment);
        this.checkArea.appendChild(fact);
        this.checkArea.scrollTop = this.checkArea.scrollHeight;
    }
}

export { Factchecker };