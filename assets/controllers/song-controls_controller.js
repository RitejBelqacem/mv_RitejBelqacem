import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

export default class extends Controller {
    static values = {
        infoUrl: String
    }
    audioElement = null;

    play(event) {
        event.preventDefault();
        const currentSong = event.currentTarget;
        const songUrl = currentSong.getAttribute('data-url');
        
     
        if (this.audioElement && !this.audioElement.paused) {
            this.audioElement.pause();
            this.audioElement.currentTime = 0;
        }
        
        axios.get(songUrl)
        .then((response) => {
            this.audioElement = new Audio(response.data.url);
            this.audioElement.play();
        });
    }

    stop(event) {
        event.preventDefault();
        if (this.audioElement) {
            this.audioElement.pause(); 
            this.audioElement.currentTime = 0; 
        }
    }
}
