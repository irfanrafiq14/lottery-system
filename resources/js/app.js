import './bootstrap';
import { initRealtime } from './realtime';

const context = document.querySelector('meta[name="realtime-context"]')?.content;

if (context) {
    initRealtime(context);
}
