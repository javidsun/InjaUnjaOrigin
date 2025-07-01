<template>
  <footer class="footer glassy-footer">
    <v-tooltip bottom><template #activator="{ on, attrs }"><span v-bind="attrs" v-on="on"><v-btn icon class="footer-btn" aria-label="Home"><v-icon>mdi-home</v-icon></v-btn></span></template><span>Home</span></v-tooltip>
    <v-tooltip bottom><template #activator="{ on, attrs }"><span v-bind="attrs" v-on="on"><v-btn icon class="footer-btn" aria-label="Favorites"><v-icon>mdi-heart</v-icon></v-btn></span></template><span>Favorites</span></v-tooltip>
    <v-tooltip bottom><template #activator="{ on, attrs }"><span v-bind="attrs" v-on="on"><v-btn icon class="footer-btn" aria-label="Locations"><v-icon>mdi-map-marker-multiple</v-icon></v-btn></span></template><span>Locations</span></v-tooltip>
    <v-tooltip bottom><template #activator="{ on, attrs }"><span v-bind="attrs" v-on="on"><v-btn icon class="footer-btn" aria-label="Messages"><v-icon>mdi-message</v-icon></v-btn></span></template><span>Messages</span></v-tooltip>
    <v-tooltip bottom><template #activator="{ on, attrs }"><span v-bind="attrs" v-on="on"><v-btn icon class="footer-btn" aria-label="Account"><v-icon>mdi-account</v-icon></v-btn></span></template><span>Account</span></v-tooltip>
  </footer>
</template>

<style scoped>
.footer.glassy-footer {
  background: rgba(30, 34, 44, 0.85);
  color: #fff;
  width: 100%;
  padding: 18px 0 10px 0;
  border-top: 1px solid rgba(255,255,255,0.08);
  position: fixed;
  bottom: 0;
  left: 0;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  gap: 32px;
  box-shadow: 0 0 32px 0 rgba(31, 38, 135, 0.18);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  z-index: 100;
}
.footer-btn {
  background: rgba(255,255,255,0.10);
  backdrop-filter: blur(8px);
  border-radius: 50%;
  width: 54px;
  height: 54px;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
  transition: all 0.3s cubic-bezier(.4,2,.3,1);
  font-size: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.10);
}
.footer-btn:hover, .footer-btn:focus {
  background: rgba(255,255,255,0.22);
  color: #ffd600;
  outline: none;
  transform: scale(1.08);
}
@media (max-width: 992px) {
  .footer.glassy-footer {
    gap: 10px;
    padding: 10px 0 6px 0;
  }
  .footer-btn {
    width: 44px;
    height: 44px;
    font-size: 1.2rem;
  }
}
</style>
