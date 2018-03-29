  <!-- Scripts -->
    @include('layouts.modals')

         
 <!-- Footer Start -->
    <footer class="dd-footer">
      <div class="container">
        <div class="row">
          <div class="dd-footer-nav">
            <ul class="list-inline">
    
    <li class="">
        <a href="{{url('/')}}storage/documents/Terms-of-Use.pdf" target="_blank" style="">
            
            <span>Terms of use</span>
        </a>
            </li>
<!--  <li class="">
        <a href="{{url('/')}}storage/documents/Vendor.docx" target="_blank" style="">
            
            <span>Vendor</span>
        </a>
            </li> -->
    
    <li class="">
        <a href="{{url('/')}}storage/documents/Policy.pdf" target="_blank" style="">
            
            <span>Privacy Policy</span>
        </a>
            </li>
    @if(Auth::check())        
    @if(Auth::user()->role_id !=3)        
    <li class="">
        <a href="{{url('/')}}storage/documents/vendor-bba.pdf" target="_blank" style="">
            
            <span>Vendors Policy</span>
        </a>
    </li>    
    @endif  
    @endif  

    
    <li class="">
        <a href="#" target="_self" style="">
            
            <span>2017 © Surf Health</span>
        </a>
            </li>

    
   <!--  <li class="">
        <a href="#" target="_self" style="">
            
            <span>Guest Controls</span>
        </a>
            </li> -->

    
 <!--    <li class="">
        <a href="#" target="_self" style="">
            
            <span>Language</span>
        </a>
            </li> -->

    
    <li class="">
        <a href="{{url('/')}}help" target="_self" style="">
            
            <span>Help</span>
        </a>
            </li>

    
    <li class="">
        <a href="{{url('/')}}contactus" target="_self" style="">
            
            <span>Contact Us</span>
        </a>
            </li>

</ul>

          </div>
          
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    @include('layouts.scripts')
</body>
</html>
