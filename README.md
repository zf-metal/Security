ZfMetal

Modulo de autenticación y autorización Zend Framework 3



---

==Render Default Partial Menu==


<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" >
    <div class="container">
        <div class="navbar-header">
            ....
        </div>

        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav">
                <!--RENDER YOUR NAV-->         
            </ul>
            
            <ul class="nav navbar-nav navbar-right">
                <!--Render zf-metal/security partial menu-->
                <?php echo $this->partial('zf-metal/security/menu/menu'); ?>
            </ul>
            
        </div>


    </div>
</nav>
