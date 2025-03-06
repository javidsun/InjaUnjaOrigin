<template>
  <footer class="footer">
    <v-btn icon class="footer-btn"><v-icon>mdi-home</v-icon></v-btn>
    <v-btn icon class="footer-btn"><v-icon>mdi-heart</v-icon></v-btn>
    <v-btn icon class="footer-btn"><v-icon>mdi-map-marker-multiple</v-icon></v-btn>
    <v-btn icon class="footer-btn"><v-icon>mdi-message</v-icon></v-btn>
    <v-btn icon class="footer-btn"><v-icon>mdi-account</v-icon></v-btn>
  </footer>
</template>

<style scoped>
.footer{

}


@media (min-width: 993px) {
  .footer {
    width: 100%;
    padding: 15px 0;
    color: var(--text-color);
    border-top: 1px solid rgba(0, 0, 0, 0.1);

    position: fixed;
    bottom: 0;
    left: 0;

    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 30px;
  }

}
@media (max-width: 992px) {
  .footer {
    background-color: var(--background-color);
    width: 100%;
    padding: 15px 0;
    color: var(--text-color);
    border-top: 1px solid rgba(0, 0, 0, 0.1);

    position: fixed;
    bottom: 0;
    left: 0;

    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 8px;
  }

}

.footer-btn {
  background-color: rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  color: var(--text-color);
  transition: all 0.3s ease;
}

.footer-btn:hover {
  background-color: rgba(255, 255, 255, 0.4);
}

p {
  margin-left: 20px;
  font-size: 12px;
}
</style>
