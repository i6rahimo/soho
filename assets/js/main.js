
window.addEventListener('scroll', function() {
    
    if(this.window.scrollY >= 1400) {
        const leftSideBar = document.querySelector('.about__col-one').classList.add('fixed')
    }else {
        const leftSideBar = document.querySelector('.about__col-one').classList.remove('fixed')
    }
  });