class SiteHeader extends HTMLElement{
    connectedCallBack(){
        this.innerHTML = `
            <div class="nav-content">
                <img src="assets/img/svg/logo.svg" class="logo-img" alt="brand-logo"/>
                <img src="assets/img/svg/tagline.svg" class="tagline-img" alt="brand-tagline"/>
            </div>
        `
    }
}

customElements.define('site-header', SiteHeader);