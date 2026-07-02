import './bootstrap';
import { initCountdownElements } from './countdown';
import { initRealtime } from './realtime';

initCountdownElements();

const context = document.querySelector('meta[name="realtime-context"]')?.content;

if (context) {
    initRealtime(context);
}
