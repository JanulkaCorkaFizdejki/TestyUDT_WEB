document.addEventListener('DOMContentLoaded', function () {
  class Slide {
    constructor($el) {
      this.$el = $el;
      this.$hamburger = $el.querySelector('.hamburger');
      this.$navLinks = $el.querySelector('.nav-links');
      this.$pageContent = $el.querySelector('.page-content');
      this.init();
    }

    init() {
      this.events()
      this.initPageUp()
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
      [...this.$navLinks.children[0].children].forEach((el, index) => {
        el.addEventListener('click', link => {
          this.pageForLink(index)
        });
      });

      // Event for window location to reload page on hash change
      window.addEventListener('hashchange', e => {
        if (!this.$navLinks.classList.contains('nav-slide-active'))
        window.location.reload()
      })

      // Event for download button on download page
      const page1Btn = document.querySelector('#download button')
      const mainBtn = document.querySelector('.main-page button.main-btn')
      const downloadModal = document.querySelector('.download-modal-bg')
      const closeBtn = downloadModal.querySelector('.download-modal-close')
      const downloadVersion1 = downloadModal.querySelector('#version1')
      const downloadVersion2 = downloadModal.querySelector('#version2')

      page1Btn.addEventListener('click', e => {
        downloadModal.classList.add('download-modal-active')
      })
      mainBtn.addEventListener('click', e => {
        downloadModal.classList.add('download-modal-active')
      })

      closeBtn.addEventListener('click', e => {
        downloadModal.classList.remove('download-modal-active')
      })

      downloadVersion1.addEventListener('click', e => {
      //  HERE VERSION ONE
        console.log(e);
      })

      downloadVersion2.addEventListener('click', e => {
        //  HERE VERSION TWO
        console.log(e);
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

      // adds class to active page, or to first
      this.$pageContent.children[lastPageIndex].classList.add('page-content-active');

      // adds highlight to last link
      this.$navLinks.children[0].children[lastPageIndex].classList.add('nav-link-color')

      // switches display and turns on animation of page content
      if (this.$navLinks.classList.contains('nav-slide-active')) {
        this.$pageContent.children[lastPageIndex].firstElementChild.classList.remove('display-none');
        this.$pageContent.children[lastPageIndex].style.animation = 'pageContentPop 0.3s ease-in';
        this.$pageContent.children[lastPageIndex].style.visibility = 'visible'
      } else {
        [...this.$pageContent.children].forEach(e => e.firstElementChild.classList.add('display-none'));
        this.$pageContent.children[lastPageIndex].style.animation = '';
        this.$pageContent.children[lastPageIndex].style.visibility = 'hidden'
      }
    };

    hamburgerClickScrollUp() {
      if (this.$hamburger.classList.contains('hamburger-active')) {
          window.scroll({top:0, left:0, behavior: "smooth"});
      }
    };

    pageForLink(linkIndex) {
      // switches page content according to link
      [...this.$pageContent.children].forEach(e => e.classList.remove('page-content-active'));
      this.$pageContent.children[linkIndex].classList.add('page-content-active');

      // switches display according to link
      [...this.$pageContent.children].forEach(e => e.firstElementChild.classList.add('display-none'));
      this.$pageContent.children[linkIndex].firstElementChild.classList.remove('display-none');

      // switches highlighting according to link
      [...this.$navLinks.children[0].children].forEach(e => e.classList.remove('nav-link-color'))
      this.$navLinks.children[0].children[linkIndex].classList.add('nav-link-color')
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

    // when given exact addres, brings page up
    initPageUp () {
      const links = [...this.$navLinks.querySelectorAll('a')]
      let address =  window.location.href.split('#')[1]
      for (const [index, linkNode] of Object.entries(links)) {
        let linkName = linkNode.href.split('#')[1]
        if (address === linkName) {
          this.pageContentUp(index);
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
    languageFocus() {
      // remove underline from all link
      this.$langLinks.forEach(link => link.classList.remove('language-selected'))

      // adds underline on active link
      const $langFocus = this.$el.querySelector(`#language-${this.defaultLanguage}`)
      $langFocus.classList.add('language-selected')
    }
  } // end Language class

  // const $lang = document.querySelector('.language')
  // if ($lang !== null) {
  //   const langClass = new Language($lang);
  // }


  /*
  * Interactive image class
  * TODO not yet ready
  * */
  class InteractiveImage {
    constructor($el) {
      this.$el = $el;
      this.$image = $el.querySelector('h1')
      this.events();
    }
    events() {
      this.$image.addEventListener('mouseover', e => {
        this.imageMove()
      })

    };

    imageMove() {
    document.onmousemove = handleMouseMove;
    function handleMouseMove(event) {
      let eventDoc, doc, body;

      if (event.pageX == null && event.clientX != null) {
          eventDoc = (event.target && event.target.ownerDocument) || document;
          doc = eventDoc.documentElement;
          body = eventDoc.body;

          event.pageX = event.clientX +
            (doc && doc.scrollLeft || body && body.scrollLeft || 0) -
            (doc && doc.clientLeft || body && body.clientLeft || 0);
          event.pageY = event.clientY +
            (doc && doc.scrollTop  || body && body.scrollTop  || 0) -
            (doc && doc.clientTop  || body && body.clientTop  || 0 );
      }
      this.$image.style.transform = `translate3d(${event.pageX} ${event.pageY} 5px)`
    }};
  } // end class interactiveImage

  // const caption = document.querySelector('.caption');
  // if (caption !== null) {
  //   new InteractiveImage(caption)
  // }


}); // end DOMContentLoaded


