<?php

/* default/index.html.twig */
class __TwigTemplate_30e1e3d9b264c6c83bf99e2798b1c18c327515ad36088816c01d9fbbc41e6818 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "default/index.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_d3296f190aff5d1dd94a9276293b1b1c16ff6130e1188abcc531abdc241a2e61 = $this->env->getExtension("native_profiler");
        $__internal_d3296f190aff5d1dd94a9276293b1b1c16ff6130e1188abcc531abdc241a2e61->enter($__internal_d3296f190aff5d1dd94a9276293b1b1c16ff6130e1188abcc531abdc241a2e61_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "default/index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_d3296f190aff5d1dd94a9276293b1b1c16ff6130e1188abcc531abdc241a2e61->leave($__internal_d3296f190aff5d1dd94a9276293b1b1c16ff6130e1188abcc531abdc241a2e61_prof);

    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        $__internal_46d5ef6efbf65339b2c04b1874ccc2d31645c92066a027e82b2d8133d11cb783 = $this->env->getExtension("native_profiler");
        $__internal_46d5ef6efbf65339b2c04b1874ccc2d31645c92066a027e82b2d8133d11cb783->enter($__internal_46d5ef6efbf65339b2c04b1874ccc2d31645c92066a027e82b2d8133d11cb783_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 4
        echo "CreateSafe
";
        
        $__internal_46d5ef6efbf65339b2c04b1874ccc2d31645c92066a027e82b2d8133d11cb783->leave($__internal_46d5ef6efbf65339b2c04b1874ccc2d31645c92066a027e82b2d8133d11cb783_prof);

    }

    // line 7
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_14c16795eb5058a2f8e2b8a803bcb3bb38d522d999b50ba1aeef97e33af78b3e = $this->env->getExtension("native_profiler");
        $__internal_14c16795eb5058a2f8e2b8a803bcb3bb38d522d999b50ba1aeef97e33af78b3e->enter($__internal_14c16795eb5058a2f8e2b8a803bcb3bb38d522d999b50ba1aeef97e33af78b3e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 8
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/dropzone.min.css"), "html", null, true);
        echo "\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/basic.css"), "html", null, true);
        echo "\" />
";
        
        $__internal_14c16795eb5058a2f8e2b8a803bcb3bb38d522d999b50ba1aeef97e33af78b3e->leave($__internal_14c16795eb5058a2f8e2b8a803bcb3bb38d522d999b50ba1aeef97e33af78b3e_prof);

    }

    // line 12
    public function block_body($context, array $blocks = array())
    {
        $__internal_43d52862ef52a2e26d8d4ef3cef990ee92e6d566b2480fa76033985e8a81c5b6 = $this->env->getExtension("native_profiler");
        $__internal_43d52862ef52a2e26d8d4ef3cef990ee92e6d566b2480fa76033985e8a81c5b6->enter($__internal_43d52862ef52a2e26d8d4ef3cef990ee92e6d566b2480fa76033985e8a81c5b6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 13
        echo "<header>
  <div class=\"navbar navbar-default navbar-fixed-top\">
    <div class=\"container-fluid\">
      <div class=\"navbar-header\">
        <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">
          <span class=\"sr-only\">Toggle navigation</span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
        </button>
        <a class=\"navbar-brand\" href=\"index.php\">
        </a>
      </div>
      <nav id=\"navbar\" class=\"navbar-collapse collapse\">
        <ul class=\"nav navbar-nav navbar-right\">
          <li><a href=\"index.php\">Home</a></li>
          <li class=\"dropdown\">
            <a href=\"About.php\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">About</a>
            <ul class=\"dropdown-menu\">
              <li><a href=\"#\">Team 33</a></li>
              <li><a href=\"#\">AuthoRight</a></li>
            </ul>
          </li>
          <li class=\"dropdown\">
            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Background</a>
            <ul class=\"dropdown-menu\">
              <li><a href=\"#\">Requirements</a></li>
              <li><a href=\"#\">Research</a></li>
              <li><a href=\"#\">Project Management</a></li>
            </ul>
          </li>
          <li class=\"dropdown\">
            <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Project</a>
            <ul class=\"dropdown-menu\">
              <li><a href=\"#\">Development</a></li>
              <li><a href=\"#\">Testing</a></li>
              <li><a href=\"#\">Use Cases</a></li>
            </ul>
          </li>
        </ul>
      </nav><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
  </div>
</header>
<div class=\"container-fluid\" id=\"mainBody\">
    <div class=\"row\">
        <div class=\"jumbotron\">
            <h1>CreateSafe!</h1>
            <p>A quick, secure, easy way to register the copyright in your creative work.</p>
            <p>
                <button type=\"button\" class=\"btn btn-primary btn-lg\" data-toggle=\"modal\" data-target=\"#myModal\">
                Protect Now
                </button>
            </p>
        </div>
    </div>
</div>

<!-- Modal -->
<div class=\"modal fade\" id=\"myModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
  <div class=\"modal-dialog\" role=\"document\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
        <h4 class=\"modal-title\" id=\"myModalLabel\">Modal title</h4>
      </div>
      <div class=\"modal-body\">
        <form id=\"dropzone\" action=\"";
        // line 80
        echo twig_escape_filter($this->env, $this->env->getExtension('oneup_uploader')->endpoint("gallery"), "html", null, true);
        echo "\" class=\"dropzone\">
        </form>
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
        <button type=\"button\" class=\"btn btn-primary\">Save changes</button>
      </div>
    </div>
  </div>
</div>
";
        
        $__internal_43d52862ef52a2e26d8d4ef3cef990ee92e6d566b2480fa76033985e8a81c5b6->leave($__internal_43d52862ef52a2e26d8d4ef3cef990ee92e6d566b2480fa76033985e8a81c5b6_prof);

    }

    // line 92
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_0081612fb1825ca29f04d4fcfd75b9be00f4adc29fbb7e89adc55f4cf3f3cc48 = $this->env->getExtension("native_profiler");
        $__internal_0081612fb1825ca29f04d4fcfd75b9be00f4adc29fbb7e89adc55f4cf3f3cc48->enter($__internal_0081612fb1825ca29f04d4fcfd75b9be00f4adc29fbb7e89adc55f4cf3f3cc48_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 93
        echo "<script>
\$(document).ready(function () {
    \$(\"#dropzone\").dropzone({
        maxFilesize: 10, //MB; remember to change upload_max_filesize in php.ini too!!
        acceptedFiles: \"application/msword,application/pdf,image/*\",
        init: function() {
          this.on(\"addedfile\", function(file) {
            // Create the remove button
            var removeButton = Dropzone.createElement(\"<button class=\\\"btn btn-xs btn-danger\\\">Remove File</button>\");


            // Capture the Dropzone instance as closure.
            var _this = this;

            // Listen to the click event
            removeButton.addEventListener(\"click\", function(e) {
              // Make sure the button click doesn't submit the form:
              e.preventDefault();
              e.stopPropagation();

              // Remove the file preview.
              _this.removeFile(file);
              Alert('";
        // line 115
        echo twig_escape_filter($this->env, (isset($context["cache"]) ? $context["cache"] : $this->getContext($context, "cache")), "html", null, true);
        echo "');
            });

            // Add the button to the file preview element.
            file.previewElement.appendChild(removeButton);
          });
        }
    });
});
</script>
 <script src=\"";
        // line 125
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/dropzone.js"), "html", null, true);
        echo "\"></script>
";
        
        $__internal_0081612fb1825ca29f04d4fcfd75b9be00f4adc29fbb7e89adc55f4cf3f3cc48->leave($__internal_0081612fb1825ca29f04d4fcfd75b9be00f4adc29fbb7e89adc55f4cf3f3cc48_prof);

    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  207 => 125,  194 => 115,  170 => 93,  164 => 92,  146 => 80,  77 => 13,  71 => 12,  62 => 9,  57 => 8,  51 => 7,  43 => 4,  37 => 3,  11 => 1,);
    }
}
/* {% extends 'base.html.twig' %}*/
/* */
/* {% block title %}*/
/* CreateSafe*/
/* {% endblock %}*/
/* */
/* {% block stylesheets %}*/
/* <link rel="stylesheet" type="text/css" href="{{ asset('css/dropzone.min.css') }}" />*/
/* <link rel="stylesheet" type="text/css" href="{{ asset('css/basic.css') }}" />*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/* <header>*/
/*   <div class="navbar navbar-default navbar-fixed-top">*/
/*     <div class="container-fluid">*/
/*       <div class="navbar-header">*/
/*         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">*/
/*           <span class="sr-only">Toggle navigation</span>*/
/*           <span class="icon-bar"></span>*/
/*           <span class="icon-bar"></span>*/
/*           <span class="icon-bar"></span>*/
/*         </button>*/
/*         <a class="navbar-brand" href="index.php">*/
/*         </a>*/
/*       </div>*/
/*       <nav id="navbar" class="navbar-collapse collapse">*/
/*         <ul class="nav navbar-nav navbar-right">*/
/*           <li><a href="index.php">Home</a></li>*/
/*           <li class="dropdown">*/
/*             <a href="About.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About</a>*/
/*             <ul class="dropdown-menu">*/
/*               <li><a href="#">Team 33</a></li>*/
/*               <li><a href="#">AuthoRight</a></li>*/
/*             </ul>*/
/*           </li>*/
/*           <li class="dropdown">*/
/*             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Background</a>*/
/*             <ul class="dropdown-menu">*/
/*               <li><a href="#">Requirements</a></li>*/
/*               <li><a href="#">Research</a></li>*/
/*               <li><a href="#">Project Management</a></li>*/
/*             </ul>*/
/*           </li>*/
/*           <li class="dropdown">*/
/*             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Project</a>*/
/*             <ul class="dropdown-menu">*/
/*               <li><a href="#">Development</a></li>*/
/*               <li><a href="#">Testing</a></li>*/
/*               <li><a href="#">Use Cases</a></li>*/
/*             </ul>*/
/*           </li>*/
/*         </ul>*/
/*       </nav><!--/.nav-collapse -->*/
/*     </div><!--/.container-fluid -->*/
/*   </div>*/
/* </header>*/
/* <div class="container-fluid" id="mainBody">*/
/*     <div class="row">*/
/*         <div class="jumbotron">*/
/*             <h1>CreateSafe!</h1>*/
/*             <p>A quick, secure, easy way to register the copyright in your creative work.</p>*/
/*             <p>*/
/*                 <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">*/
/*                 Protect Now*/
/*                 </button>*/
/*             </p>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */
/* <!-- Modal -->*/
/* <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">*/
/*   <div class="modal-dialog" role="document">*/
/*     <div class="modal-content">*/
/*       <div class="modal-header">*/
/*         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>*/
/*         <h4 class="modal-title" id="myModalLabel">Modal title</h4>*/
/*       </div>*/
/*       <div class="modal-body">*/
/*         <form id="dropzone" action="{{ oneup_uploader_endpoint('gallery') }}" class="dropzone">*/
/*         </form>*/
/*       </div>*/
/*       <div class="modal-footer">*/
/*         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>*/
/*         <button type="button" class="btn btn-primary">Save changes</button>*/
/*       </div>*/
/*     </div>*/
/*   </div>*/
/* </div>*/
/* {% endblock %}*/
/* */
/* {% block javascripts %}*/
/* <script>*/
/* $(document).ready(function () {*/
/*     $("#dropzone").dropzone({*/
/*         maxFilesize: 10, //MB; remember to change upload_max_filesize in php.ini too!!*/
/*         acceptedFiles: "application/msword,application/pdf,image/*",*/
/*         init: function() {*/
/*           this.on("addedfile", function(file) {*/
/*             // Create the remove button*/
/*             var removeButton = Dropzone.createElement("<button class=\"btn btn-xs btn-danger\">Remove File</button>");*/
/* */
/* */
/*             // Capture the Dropzone instance as closure.*/
/*             var _this = this;*/
/* */
/*             // Listen to the click event*/
/*             removeButton.addEventListener("click", function(e) {*/
/*               // Make sure the button click doesn't submit the form:*/
/*               e.preventDefault();*/
/*               e.stopPropagation();*/
/* */
/*               // Remove the file preview.*/
/*               _this.removeFile(file);*/
/*               Alert('{{ cache }}');*/
/*             });*/
/* */
/*             // Add the button to the file preview element.*/
/*             file.previewElement.appendChild(removeButton);*/
/*           });*/
/*         }*/
/*     });*/
/* });*/
/* </script>*/
/*  <script src="{{ asset('js/dropzone.js') }}"></script>*/
/* {% endblock %}*/
