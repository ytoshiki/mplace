document.addEventListener("DOMContentLoaded", () => {
  const init = new Init();
});

class Init {
  constructor() {
    this.dom();
    this.addEvent();
  }

  dom() {
    this.bookmarkLinks = document.querySelectorAll(".bookmark");
    this.bookmarkModal = document.querySelector('.bookmark_modal');
    this.bookmarkShadow = document.querySelector('.bookmark_shadow');
    this.bookmarkSignup = document.querySelector('#signup_button');
    this.bookmarkNav = document.querySelector('.bookmark_nav');
    this.commentInputs = document.querySelectorAll('.comment_input');
    this.bookmarkLinksSp = document.querySelectorAll('.bookmark_link_sp');
    this.shareLinks = document.querySelectorAll('.share_link');
    this.urlModal = document.querySelector('.url_modal');
    this.urlShadow = document.querySelector('.url_shadow');
    this.urlInsert = document.querySelector('.url_insert');
    this.copybtn = document.querySelector('.copy_button');
  
   
  }

  addEvent() {
    this.bookmarkLinks.forEach(link => {
      link.addEventListener("click", (e) => {
        console.log("clicked");
        
        const parentDiv = e.target.parentElement;
        if(parentDiv.classList.contains("authorized")){
       
        } else {
          e.preventDefault();
          this.bookmarkModal.classList.add("display");
          document.body.style.height = "100vh";
          document.body.style.overflowY = "hidden";
         
        }
      });
    })

    if(this.bookmarkShadow) {
      this.bookmarkShadow.addEventListener("click", () => {
        this.bookmarkModal.classList.remove("display");
        document.body.style.height = "";
        document.body.style.overflowY = "";
      })
    }

    if(this.urlShadow) {
      this.urlShadow.addEventListener("click", () => {
        this.urlModal.classList.remove("display");
        document.body.style.height = "";
        document.body.style.overflowY = "";
        this.urlInsert.classList.remove("action");
        this.urlInsert.style.background = ""; 
      })
    }
    
    

    if(this.bookmarkSignup) {
      this.bookmarkSignup.addEventListener("click", () => {
        this.bookmarkModal.classList.remove("display");
        document.body.style.height = "";
        document.body.style.overflowY = "";
      })
    }

    if(this.commentInputs) {
      this.commentInputs.forEach(input => {
        input.addEventListener("focus", (e) => {
          const textarea = e.target;
          if(textarea.classList.contains("authenticated")) {

          } else {
            this.bookmarkModal.classList.add("display");
            document.body.style.height = "100vh";
            document.body.style.overflowY = "hidden";
          }

        })
      })
    }

    if(this.bookmarkNav) {
      this.bookmarkNav.addEventListener("click", (e) => {
        if(e.target.classList.contains("authenticated")) {
          
        } else {
          e.preventDefault();
          this.bookmarkModal.classList.add("display");
          document.body.style.height = "100vh";
          document.body.style.overflowY = "hidden";
        }
      }
      )
    }

    if(this.bookmarkLinksSp) {
      this.bookmarkLinksSp.forEach(link => {
        link.addEventListener("click", (e) => {
          
          if(e.target.classList.contains("authenticated")) {

          } else {
            e.preventDefault();
            this.bookmarkModal.classList.add("display");
            document.body.style.height = "100vh";
            document.body.style.overflowY = "hidden";
          }
          
        })
      })
     
    }

    if(this.shareLinks) {
      this.shareLinks.forEach(link => {
        link.addEventListener("click", (e) => {
          const image = e.target;
          const url = image.getAttribute("data-url");
          this.urlInsert.textContent = url;
          this.enableCopy(url, image)
          this.urlModal.classList.add("display");
          document.body.style.height = "100vh";
          document.body.style.overflowY = "hidden";
          
        }) 
      })
    }
  }

  enableCopy(url) {
   
    this.copybtn.addEventListener("click", () => {
     
      const dummy = document.createElement("textarea");
      document.body.appendChild(dummy);
      dummy.value = url;
      dummy.select();
      document.execCommand("copy");
      document.body.removeChild(dummy);
      this.urlInsert.classList.add("action");  
      this.urlInsert.style.background = "#d3d3d3"; 
    })
  }
}