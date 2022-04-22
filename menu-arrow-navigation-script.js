// v 1.0
document.addEventListener("DOMContentLoaded", function(event) {

// querySelecting
  const focusablePrimaryMenuElements= document.querySelectorAll(`${primaryMenuSelector}`);
  const mainContentElement = document.querySelector(`${mainContentSelector}`)
  mainContentElement.setAttribute("tabindex", "-1");
  const menuEntire = document.querySelector(`${wholeMenuSelector}`);
  const focusableSecondaryMenuElements= document.querySelectorAll(`${secondaryMenuItemSelector}, ${primaryMenuSelector}`);

// Destructuring
  const focusablePrimary = [...focusablePrimaryMenuElements];
  const focusableSecondary = [...focusableSecondaryMenuElements];
  
// Event Listeners
  for (i=0;i<focusablePrimary.length;i++) {
    focusablePrimary[i].addEventListener("focus", () => {
      listenForKeystrokes();
    })
    focusablePrimary[i].addEventListener("click", () => {
      removeInstructions();
    })
    focusablePrimary[i].addEventListener("blur", () => {
      ignoreKeystrokes();
    });
    focusablePrimary[focusablePrimary.length-1].addEventListener("focus", () => {
      listenForFocusOut();
    })
    focusablePrimary[focusablePrimary.length-1].addEventListener("blur", () => {
      ignoreFocusOut();
    })
  }

  focusablePrimary[0].addEventListener("focus", () => {
    popupInstructions();
  });
  focusablePrimary[focusablePrimary.length-1].addEventListener("blur", () => {
    removeInstructions();
  });
  
  for (i=0;i<focusableSecondary.length;i++) {
    focusableSecondary[i].addEventListener("focus", () => {
      listenForVerticalKeystrokes();
    })
    focusableSecondary[i].addEventListener("click", () => {
      removeInstructions();
    })
    focusableSecondary[i].addEventListener("blur", () => {
      ignoreVerticalKeystrokes();
      //removeInstructions();
    });
  }
  // create instructions
  const navInstructions = document.createElement('div');
  navInstructions.className = "nav-instructions";
  navInstructions.style.color=`${instructionsColor}`;
  navInstructions.style.top=`${fromTopLocation}`;
  navInstructions.textContent = "Use the arrow keys to navigate the menu. To enter the page, use the right arrow key from the last main menu item.";
// Functions
  
  // instructions
  function popupInstructions(){
    menuEntire.prepend(navInstructions);
    const navInstructionExtra = document.querySelectorAll('.nav-instructions');
    navInstructionsExtra = [...navInstructionExtra];
    navInstructionExtra[1].remove();
  }
  
  function removeInstructions(){
    document.querySelector('.nav-instructions').remove()
  }
  
  // keystroke listeners
  function listenForKeystrokes(){
    document.addEventListener("keydown", handleMenuFocusTransfer);
  }
  function ignoreKeystrokes() {
    document.removeEventListener("keydown", handleMenuFocusTransfer);
  }

  function listenForVerticalKeystrokes(){
    document.addEventListener("keydown", handleMenuFocusTransferVertical);
  }
  function ignoreVerticalKeystrokes() {
    document.removeEventListener("keydown", handleMenuFocusTransferVertical);
  }
  function listenForFocusOut() {
    document.addEventListener("keydown", handleMenuFocusOut);
  }
  function ignoreFocusOut() {
    document.removeEventListener("keydown", handleMenuFocusOut);
  }

    // moving focus
  function handleMenuFocusTransfer(e){
    const index = focusablePrimary.indexOf(document.activeElement);

    let nextIndex = 0;

    if (e.keyCode === 37) {
      // left arrow
      e.preventDefault();
      nextIndex= index > 0 ? index-1 : 0;
      focusablePrimaryMenuElements[nextIndex].focus();
    }
    else if (e.keyCode === 39) {
      // right arrow
      e.preventDefault();
      nextIndex= index < focusablePrimary.length ? index+1 : index;
        focusablePrimaryMenuElements[nextIndex].focus();
    }
  }

  function handleMenuFocusTransferVertical(e){
    const verticalIndex = focusableSecondary.indexOf(document.activeElement);

    let nextIndex = 0;

    if (e.keyCode === 38) {
      // up arrow
      e.preventDefault();
      nextIndex= verticalIndex > 0 ? verticalIndex-1 : 0;
      focusableSecondaryMenuElements[nextIndex].focus();
    }
    else if (e.keyCode === 40) {
      // down arrow
      e.preventDefault();
      nextIndex= verticalIndex+1 < focusableSecondary.length ? verticalIndex+1 : verticalIndex;
      focusableSecondaryMenuElements[nextIndex].focus();
    }
  }

  function handleMenuFocusOut(e) {
    if (e.keyCode === 39) {
      e.preventDefault();
      mainContentElement.focus();
    }
  }
});