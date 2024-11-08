import './bootstrap';

import './bootstrap';
import { Tooltip, Toast, Popover } from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map((tooltipTriggerEl) => new Tooltip(tooltipTriggerEl));
});