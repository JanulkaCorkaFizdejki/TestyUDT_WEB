document.addEventListener('DOMContentLoaded', function () {
  class Slide {
    constructor($el) {
      this.$el = $el;
      this.$hamburger = $el.querySelector('.hamburger');
      this.$navLinks = $el.querySelector('.nav-links');
      this.$pageContent = $el.querySelector('.page-content');
      this.$menuItems = $el.querySelectorAll('.menu-item');
      this.$coverBg = $el.querySelector('.cover-bg');
      this.$footerBg = document.querySelector('.footer');
      this.etiquett = document.querySelector('#link-etiquett')
      this.menuPageWrappers = document.querySelectorAll('.menu-page-wrapper')
      this.init();
    }

    init() {
      this.events();
      this.initPageUp();
    }

    events() {
      // Arrow moves right-left animation
      this.$hamburger.addEventListener('mouseover', e => {
        this.arrowMoveRight();
      });
      this.$hamburger.addEventListener('mouseout', e => {
        this.arrowMoveLeft();
      });

      // Page content bar moves in visible area
      this.$hamburger.addEventListener('click', e => {
        let lastPageIndex = this.lastPage(this.$pageContent.children, 'page-content-active');
        this.pageContentUp(lastPageIndex);
        this.hamburgerClickScrollUp();
      });

      // Switch page on link click
      for (const a of this.$menuItems) {
        a.addEventListener('click', e => {
          this.menuPageManager(a, this.menuPageWrappers)
        })
      }

      // Event for window location to reload page on hash change
      window.addEventListener('hashchange', e => {
        if (!this.$navLinks.classList.contains('nav-slide-active'))
          window.location.reload()
      })

    };

    /*
     *    METHODS
     */
    arrowMoveRight() {
      this.$hamburger.classList.add('arrow-hover')
    };

    arrowMoveLeft() {
      this.$hamburger.classList.remove('arrow-hover')
    };

    // moves side bar with content to visible area
    pageContentUp(lastPageIndex) {
      // switches animation of hamburger
      this.$hamburger.classList.toggle('hamburger-active');
      this.$navLinks.classList.toggle('nav-slide-active');

      // changes background if slide bar active
      if (this.$hamburger.classList.contains('hamburger-active')) {
        this.$coverBg.style.opacity = "1";
        this.$footerBg.style.backgroundColor = "#2b2b2b";
      } else {
        this.$coverBg.style.opacity = "0";
        this.$footerBg.style.backgroundColor = "#333333";
        this.etiquett.style.display = 'none'
        this.menuPageWrappers.forEach(el => {
          el.children[0].style.visibility = 'visible'
        })
      }

      // collapses all pages on sidebar collapse
      this.$menuItems.forEach(el => {
        if (el.parentElement.children[1].classList.contains('page-content-show')) {
          el.parentElement.children[1].classList.remove('page-content-show')
          el.parentElement.children[1].classList.add('page-content-hide')
        }
      })
    };

    hamburgerClickScrollUp() {
      if (this.$hamburger.classList.contains('hamburger-active')) {
          window.scroll({top:0, left:0, behavior: "smooth"});
      }
    };

    // returns index of last viewed page
    lastPage(listOfElements, cssClass) {
      let pageIndex = 0;
      [...listOfElements].forEach((el, index) => {
        if (el.classList.contains(cssClass)) {
          pageIndex = index;
        }
      });
      return pageIndex
    };

    menuPageManager(aItem, menuPageColllection) {
      const etiquett = document.querySelector('#link-etiquett')
      const etiquettText = aItem.innerText
      const pageContent = aItem.parentNode.children[1]

      if (pageContent.classList.contains('page-content-show')) {
        pageContent.classList.add('page-content-hide')
        pageContent.classList.remove('page-content-show')
        etiquett.style.display = 'none'
        aItem.style.visibility = 'visible'
      } else {
        menuPageColllection.forEach(element => {
          element.children[1].classList.remove('page-content-show')
          element.children[1].classList.remove('page-content-hide')
          element.children[1].classList.add('page-content-hide')
          etiquett.style.display = 'none'
          element.children[0].style.visibility = 'visible'
        });
        pageContent.classList.remove('page-content-hide')
        pageContent.classList.add('page-content-show')
        etiquett.innerHTML = etiquettText
        etiquett.style.display = 'block'
        aItem.style.visibility = 'hidden'

      }
    }

    // when given exact addres, brings page up
    initPageUp () {
      const links = [...this.$menuItems]
      let address =  window.location.href.split('#')[1]
      for (const [index, linkNode] of Object.entries(links)) {
        let linkName = linkNode.href.split(`#`)[1]
        if (address === linkName) {
          this.pageContentUp(index);
          linkNode.click()
        }
      }
    }

  } // end Slide class

  const navSection = document.querySelector('.side-bar');
  if (navSection !== null) {
    new Slide(navSection);
  }


  class Cookie {
    constructor($el) {
      this.$el = $el
      this.$cookieAcceptBtn = $el.querySelector('button.ciastko-accept')
      this.$cookieCloseBtn = $el.querySelector('img.ciastko-close')
      this.cookies = {
        cookie1: {
          cname: "cookie",
          cvalue: "accepted",
          exdays: 365,
        },
        cookie2: {
          cname: "cookie2",
          cvalue: "value2",
          exdays: 1,
        }
      }
      this.init()
    }

    init() {
      this.cookieCheck()
    }


    cookieCheck() {
      const cookieTrue = this.constructor.getCookie(this.cookies.cookie1.cname)
      if (!cookieTrue) {
        this.$el.classList.add('ciastko-active')

        // listener for cookie accept, sets new cookie
        this.$cookieAcceptBtn.addEventListener('click', e => {
          const c = this.cookies.cookie1
          this.constructor.setCookie(c.cname, c.cvalue, c.exdays)
          this.$el.classList.remove('ciastko-active')
        })

        // listener for close button, do NOT sets cookie
        this.$cookieCloseBtn.addEventListener('click', e => {
          this.$el.classList.remove('ciastko-active')
        })
      }
    }

    static setCookie(cname, cvalue, exdays) {
      const date = new Date();
      date.setTime(date.getTime() + (exdays * 24 * 60 * 60 * 1000));
      const expires = "expires="+date.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    static getCookie(cname) {
      let c = document.cookie
      c = c.split(";")
      for (let cookie of c) {
        const c_split = cookie.split("=")
        if (c_split[0].trim() === cname) {
          return cookie
        }
      }
    }
  } // end Cookie class

  const cookiePopUp = document.querySelector('.ciastko-bg')
  if (cookiePopUp !== null) {
    new Cookie(cookiePopUp);
  }


  /*
  * Language class
  * */
  class Language {
    constructor($el) {
      this.$el = $el
      this.$langLinks = $el.querySelectorAll('a')
      this.languages = {pl: 'pl', uk: 'uk'}
      this.defaultLanguage = ''
      this.init()
    }

    init() {
      this.events()
      this.languageCheck()
      this.languageFocus()
      this.languageCookieSet()
    }

    events() {
      // set language on click
      this.$langLinks.forEach(link => {
        link.addEventListener('click', e => {
          this.defaultLanguage = e.target.dataset.langId
          this.languageFocus()
          this.languageCookieSet()
        })
      })
    }

    /*
    * set default language accroding to cookie, or navigator language
    * */
    languageCheck() {
      // Check what language is and set in defaultLanguage
      let cookieLang = Cookie.getCookie('language')
      if (cookieLang) {
        cookieLang = cookieLang.trim().split("=")[1]
      }
      if (cookieLang === this.languages.uk || window.location.href === 'http://testyudt.com/UK') {
        this.defaultLanguage = this.languages.uk
      } else {
        if (navigator.language === this.languages.uk) {
          this.defaultLanguage = this.languages.uk
        } else {
          this.defaultLanguage = this.languages.pl
        }
      }
    }

    /*
    * Set language in navigator cookie
    * */
    languageCookieSet() {
      Cookie.setCookie('language', this.defaultLanguage, 365)
    }

    /*
    * Set underline on active language
    * */
    // languageFocus() {
    //   // remove underline from all link
    //   this.$langLinks.forEach(link => link.classList.remove('language-selected'))
    //
    //   // adds underline on active link
    //   const $langFocus = this.$el.querySelector(`#language-${this.defaultLanguage}`)
    //   $langFocus.classList.add('language-selected')
    // }
  } // end Language class

  // const $lang = document.querySelector('.language')
  // if ($lang !== null) {
  //   const langClass = new Language($lang);
  // }

  class Download {
    constructor(downloadButtons) {
      this.$downloadButtons = downloadButtons
      this.platform = this.platformCheck()
      this.downloadUrl = {
          iphone: "https://www.apple.com/pl/search/Testy-UDT?src=serp",
          android_google: "https://play.google.com/store/search?q=testy%20udt",
          android_huawei: "https://appgallery.huawei.com/#/search/testy%20udt?1610375249495"
      }
      this.infoDiv = document.querySelectorAll('.qr-popup')
      this.init()
    }
    
    init() {
        this.buttonsForPlatform()
        this.events()
        this.infoForPlatfrom()
    }

    events() {
      this.$downloadButtons.forEach(e =>{
        e.addEventListener('click', event =>{
          if (this.platform === "iphone") {
            location.href = this.downloadUrl.iphone
          } else {
              if (e.dataset.platform === "google") {
                  location.href = this.downloadUrl.android_google
              } else if (e.dataset.platform === "huawei") {
                  location.href = this.downloadUrl.android_huawei
              }
          }
        })
      })
    }

    platformCheck() {
      return window.navigator.platform.toLowerCase().trim()
    }

    buttonsForPlatform() {
        if (this.platform === "iphone") {
            this.$downloadButtons.forEach(e => {
                if (e.dataset.platform === "google" | e.dataset.platform === "huawei") {
                    e.style.display = "none"
                }
            })
        } else {
            this.$downloadButtons.forEach( e => {
                if (e.dataset.platform === "iphone") {
                    e.style.display = "none"
                }
            })
        }
    }

    infoForPlatfrom() {
        if (this.platform === "iphone"){
            this.infoDiv.forEach(el =>{
                if (el.dataset.platform === "iphone") {
                    el.style.display = "block"
                }
            })
        } else {
            this.infoDiv.forEach(el => {
                if (el.dataset.platform === "google"){
                    el.style.display = "block"
                }
            })

        }
    }

  }

  const $downloadButton = document.querySelectorAll('.download-btn')
  if ($downloadButton !== null) {
    new Download($downloadButton)
  }

}); // end DOMContentLoaded