<section class="s-partners bg-custom-grey text-primary">
  <div class="lg:d-grid container">
    <div class="col-span-5 flex flex-col justify-center">
      <h5>Ils nous font confiance</h5>
      <h3>Ils ont choisis Magvice pour protéger leurs infrastructures </h3>
    </div>
    <div class="col-span-6 col-start-7 flex items-center">
      <div class="swiper swiper-logos">
        <div class="swiper-wrapper" data-anim="slide-right-multiple" data-offset="200">
          @for ($i = 0; $i < 4; $i++)
            <div class="swiper-slide">
              <a href="https://www.epekta.com" target="_blank">
                <figure class="s-partner__visual">
                  @svg('frontoffice.sections.partners.placeholder1')
                </figure>
              </a>
            </div>
            <div class="swiper-slide">
              <a href="https://www.epekta.com" target="_blank">
                <figure class="s-partner__visual">
                  @svg('frontoffice.sections.partners.placeholder2')
                </figure>
              </a>
            </div>
          @endfor
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
