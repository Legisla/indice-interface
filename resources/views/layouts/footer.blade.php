<footer>

    <div class="central">

        <div class="box_foot">
            <div class="footer-content">
            <div class="lcol">
                <div class="redes_foot">
                    <a href="{!! setting('social.facebook') !!}" title="" target="_blank">
                        <i class="fa fa-facebook-square"></i>
                    </a>
                    <a href="{!! setting('social.linkedin') !!}" title="" target="_blank">
                        <i class="fa fa-linkedin-square"></i>
                    </a>
                    <a href="{!! setting('social.instagram') !!}" title="" target="_blank">
                        <i class="fa fa-instagram"></i>
                    </a>
                </div>
                <a href="#" title="" class="">
                    <img src="{{asset('img/idv-marca-footer.png')}}" alt="{{setting('site.title')}}">
                </a>
            </div>

            <div class="ccol">
                <p>
                    Somos uma organização sem fins lucrativos e suprapartidária que trabalha para aprimorar a política. Apoiamos agentes políticos a adotarem práticas efetivas e representativas, fortalecendo a democracia brasileira
                </p>

                <ul>
                    <li><a href="{{url('')}}" title="Início">Início</a></li>
                    <li><a href="{{route('sobre-o-projeto')}}" title="Sobre o projeto">Sobre o projeto</a></li>
                    <li><a href="{{route('metodologia')}}" title="Metodologia">Metodologia</a></li>
                    <li><a href="{{route('quem-somos')}}" title="Quem Somos">Quem Somos</a></li>
                    <li><a href="{{route('contatos')}}" title="Contatos">Contatos</a></li>
                </ul>
            </div>

            <!-- <div class="rcol">

                <section class="text-center">
                    <div style="display: inline-block" role="main" id="receba-mais-informacoes-sobre-o-indice-584816fa25722ea15b2c"></div>

                    <script type="text/javascript"
                            src="https://d335luupugsy2.cloudfront.net/js/rdstation-forms/stable/rdstation-forms.min.js"></script>
                    <script
                        type="text/javascript"> new RDStationForms('receba-mais-informacoes-sobre-o-indice-584816fa25722ea15b2c', 'UA-163163824-1').createForm();
                    </script>
                </section>

            </div> -->
            </div>
            <div class="footer-bottom">
                <div class="footer-bottom-links">
                    <a href="{{ route('politica-de-privacidade') }}" title="Política de privacidade">Política de privacidade</a>
                    <a href="{{ route('termos-de-uso') }}" title="Termos de uso">Termos de uso</a>
                </div>
            </div>
        </div>
    
    </div>

</footer>

<script src="{{asset('js/foundation.min.js')}}"></script>
<script src="{{asset('js/jquery.mask.min.js')}}"></script>

<script src="{{mix('js/app.js')}}"></script>

<script> const baseUrl = "{{url('')}}"</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{setting('site.google_analytics_tracking_id')}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{setting('site.google_analytics_tracking_id')}}');
</script>
<script type="text/javascript" async src="https://d335luupugsy2.cloudfront.net/js/loader-scripts/b47d377c-904e-4c9e-919a-fb5b7c95a576-loader.js" ></script>
</body>
</html>
