class ResourcesAccordian {
  // TODO: accessibility!!
  // TODO: proper doc comments - set up linter
  // need to unset theTargetPanel when all closed
  constructor() {
    // The currently opened panel (element). Set in handlePanels when the current panel changes.
    this.theTargetPanel;

    // List of accordion items (buttons).
    this.toggleResourcesBtns = document.querySelectorAll(
      '.showHideResourcesBtn'
    );

    if (!this.toggleResourcesBtns || !this.toggleResourcesBtns.length) return;

    // Open/close appropiate panels when the buttons are clicked.
    this.addPanelListeners();

    // Listen for page resize, reset panel height to natural scrollHeight.
    this.addResizeListener();
  }

  addResizeListener() {
    const listener = this.handleResize.bind(this);
    window.addEventListener('resize', listener);
  }

  /**
   * Change the height of the open panel to it's natural (scrollHeight) if the page is resized. (Because panels are set to the exact scroll height when opened, content at the bottom gets cut off if the page width is reduced while the panel is open).
   * @returns {void}
   */
  handleResize() {
    const targetEl = this.theTargetPanel;
    return ResourcesAccordian.debounce(function (e) {
      // Return if all panels are closed.
      if (!targetEl) return;
      targetEl.style.maxHeight = targetEl.scrollHeight + 'px';
    }, 100)();
  }

  addPanelListeners() {
    this.toggleResourcesBtns.forEach((btn) => {
      // If btn is <button> with data-target-id attr - add click listener to open related panel.
      if (
        btn.nodeType === Node.ELEMENT_NODE &&
        btn.nodeName === 'BUTTON' &&
        btn.dataset.targetId
      ) {
        const listener = this.handlePanels.bind(this);
        btn.addEventListener('click', listener);
      }
    });
  }

  handlePanels(e) {
    e.preventDefault();

    // Return if target is not a button or doesn't have data-targetId attr.
    if (e.target.nodeName !== 'BUTTON') return;
    if (!e.target.dataset.targetId) return;

    // Get details of the related panel.
    const { targetId, targetEl } = this.panelDets(e.target);
    if (!targetId || !targetEl) return;

    // Hiding a Panel.
    if (targetEl.classList.contains('show')) {
      this.hidePanel(targetEl, e.target);
      // Important.
      return;
    }

    // Showing a panel.
    if (!targetEl.classList.contains('show')) {
      this.showPanel(targetEl, e);
      return;
    }
  }

  hidePanel(targetEl, clickedBtn) {

    // 1. Remove '.show' (display:none).
    targetEl.classList.remove('show');

    // 2. Add '.hiding' (display: grid) for the duration of the transition.
    targetEl.classList.add('hiding');

    // 3. Listen & remove '.hiding' class on transitionend.
    targetEl.addEventListener(
      'transitionend',
      ResourcesAccordian.handleTransitionEnd
    );

    // 4. Transition is on max-height.
    targetEl.style.maxHeight = null;

    // 5. Handle aria on the clicked button.
    clickedBtn.setAttribute('aria-expanded', false);

    // 6. Because only one panel can be open at a time, this.theTargetPanel has to be null if one closes.
    this.theTargetPanel = null;
  }

  showPanel(targetEl, clickEvent) {
    // 0. Hide all others & handle aria.
    this.closeAllPanels();

    // 1. So that the page resize listener knows the currently active panel element.
    this.theTargetPanel = targetEl;

    // 2. Show the relevant panel & handle button aria.
    targetEl.classList.add('show');
    targetEl.style.maxHeight = targetEl.scrollHeight + 'px';
    clickEvent.target.setAttribute('aria-expanded', true); // on the button, is this correct?
  }

  /**
   * Gets the id & element panel that correspons to btn arg.
   *
   */
  panelDets(btn) {
    // Get id of panel related to the clicked button.
    const targetId = btn.dataset.targetId;

    // Get the panel element related to the clicked button.
    const targetEl = document.getElementById(targetId);

    return {
      targetId: targetId && typeof targetId === 'string' ? targetId : null,
      targetEl:
        targetEl && targetEl.nodeType === Node.ELEMENT_NODE ? targetEl : null,
    };
  }

  /**
   * This method means that only one panel can be open at a time. Currently handleResize only resizes the last panel opened (this.theTargetPanel) so do not remove this without changing handleResize.
   */
  closeAllPanels() {
    // 0. For each btn (panel item).
    this.toggleResourcesBtns.forEach((btn) => {
      // 1. Get panel related to current btn.
      const { targetEl } = this.panelDets(btn);

      // 2. If panel is currently .show, hide it.
      if (targetEl.classList.contains('show')) {
        this.hidePanel(targetEl, btn);
      }

      // closing panels do this individulaly but Leave this just in case?
      this.theTargetPanel = null;
    });
  }

  static handleTransitionEnd() {
    // this refers to targetEl (ie this.theTargetPanel). Remove .hiding class when transition ends.
    this.classList.remove('hiding');

    // remove the listener.
    ResourcesAccordian.removeTransitionEvent(this);
  }

  static removeTransitionEvent(targetEl) {
    // Tested chrome via console->elements->EventListeners.
    targetEl.removeEventListener(
      'transitionend',
      ResourcesAccordian.handleTransitionEnd
    );
  }

  /**
   * Run the resize handler through this so it only fires according to the wait param.
   * Based on below link but don't need the immediate stuff.
   * @see https://davidwalsh.name/javascript-debounce-function
   */
  static debounce(func, wait) {
    let timeout;
    return function () {
      const context = this,
        args = arguments;
      const later = function () {
        timeout = null;
        func.apply(context, args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  }
}

export default ResourcesAccordian;
