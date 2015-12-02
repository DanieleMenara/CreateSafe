<?php

/* base.html.twig */
class __TwigTemplate_885e0b9441aea61fc32f7bd6764a63bc833fffe73c880c177085c76e2b6ee855 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_24bccb61608173639b8def648eb98daf44036f37ff7af7348547a58ab1254b75 = $this->env->getExtension("native_profiler");
        $__internal_24bccb61608173639b8def648eb98daf44036f37ff7af7348547a58ab1254b75->enter($__internal_24bccb61608173639b8def648eb98daf44036f37ff7af7348547a58ab1254b75_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <title>";
        // line 7
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 8
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 9
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
          <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
        <![endif]-->
        <!--[if lt IE 8]>
        <style>
            /*For IE < 8 (hasLayout)*/
            .clearfix {
                zoom: 1;
            }
        </style>
        <![endif]-->
        <link rel=\"stylesheet\" type=\"text/css\" href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("Bootstrap/css/bootstrap.min.css"), "html", null, true);
        echo "\">
    </head>
    <body>
        ";
        // line 26
        $this->displayBlock('body', $context, $blocks);
        // line 27
        echo "        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js\"></script>
        <script src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("jQuery/jquery-1.11.3.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("Bootstrap/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("Bootstrap/js/ie10-viewport-bug-workaround.js"), "html", null, true);
        echo "\"></script>
        ";
        // line 32
        $this->displayBlock('javascripts', $context, $blocks);
        // line 33
        echo "    </body>
</html>";
        
        $__internal_24bccb61608173639b8def648eb98daf44036f37ff7af7348547a58ab1254b75->leave($__internal_24bccb61608173639b8def648eb98daf44036f37ff7af7348547a58ab1254b75_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_5b7578ee37300d83ae3bd963c60f9c02e69a80142acfe92736321965c7a951e6 = $this->env->getExtension("native_profiler");
        $__internal_5b7578ee37300d83ae3bd963c60f9c02e69a80142acfe92736321965c7a951e6->enter($__internal_5b7578ee37300d83ae3bd963c60f9c02e69a80142acfe92736321965c7a951e6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        
        $__internal_5b7578ee37300d83ae3bd963c60f9c02e69a80142acfe92736321965c7a951e6->leave($__internal_5b7578ee37300d83ae3bd963c60f9c02e69a80142acfe92736321965c7a951e6_prof);

    }

    // line 8
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_f4298fbb1148c33b1490b5ca7c5a6b998111e264c3a70237553841258b0d53b5 = $this->env->getExtension("native_profiler");
        $__internal_f4298fbb1148c33b1490b5ca7c5a6b998111e264c3a70237553841258b0d53b5->enter($__internal_f4298fbb1148c33b1490b5ca7c5a6b998111e264c3a70237553841258b0d53b5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_f4298fbb1148c33b1490b5ca7c5a6b998111e264c3a70237553841258b0d53b5->leave($__internal_f4298fbb1148c33b1490b5ca7c5a6b998111e264c3a70237553841258b0d53b5_prof);

    }

    // line 26
    public function block_body($context, array $blocks = array())
    {
        $__internal_14f73377d768c00070f02dd443cc714af035283ca37b8d8acb329db7aff3565d = $this->env->getExtension("native_profiler");
        $__internal_14f73377d768c00070f02dd443cc714af035283ca37b8d8acb329db7aff3565d->enter($__internal_14f73377d768c00070f02dd443cc714af035283ca37b8d8acb329db7aff3565d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_14f73377d768c00070f02dd443cc714af035283ca37b8d8acb329db7aff3565d->leave($__internal_14f73377d768c00070f02dd443cc714af035283ca37b8d8acb329db7aff3565d_prof);

    }

    // line 32
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_5043a31b355ae2b2e0d49c71a1e9b611a1f2d5f8fa97bf91b3c0fb66a2fbb1d1 = $this->env->getExtension("native_profiler");
        $__internal_5043a31b355ae2b2e0d49c71a1e9b611a1f2d5f8fa97bf91b3c0fb66a2fbb1d1->enter($__internal_5043a31b355ae2b2e0d49c71a1e9b611a1f2d5f8fa97bf91b3c0fb66a2fbb1d1_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_5043a31b355ae2b2e0d49c71a1e9b611a1f2d5f8fa97bf91b3c0fb66a2fbb1d1->leave($__internal_5043a31b355ae2b2e0d49c71a1e9b611a1f2d5f8fa97bf91b3c0fb66a2fbb1d1_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  125 => 32,  114 => 26,  103 => 8,  92 => 7,  84 => 33,  82 => 32,  78 => 31,  73 => 29,  69 => 28,  66 => 27,  64 => 26,  58 => 23,  40 => 9,  38 => 8,  34 => 7,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <meta http-equiv="X-UA-Compatible" content="IE=edge">*/
/*         <meta name="viewport" content="width=device-width, initial-scale=1">*/
/*         <title>{% block title %}{% endblock %}</title>*/
/*         {% block stylesheets %}{% endblock %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*         <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->*/
/*         <!--[if lt IE 9]>*/
/*           <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>*/
/*           <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>*/
/*         <![endif]-->*/
/*         <!--[if lt IE 8]>*/
/*         <style>*/
/*             /*For IE < 8 (hasLayout)*//* */
/*             .clearfix {*/
/*                 zoom: 1;*/
/*             }*/
/*         </style>*/
/*         <![endif]-->*/
/*         <link rel="stylesheet" type="text/css" href="{{ asset('Bootstrap/css/bootstrap.min.css') }}">*/
/*     </head>*/
/*     <body>*/
/*         {% block body %}{% endblock %}*/
/*         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>*/
/*         <script src="{{ asset('jQuery/jquery-1.11.3.min.js') }}"></script>*/
/*         <script src="{{ asset('Bootstrap/js/bootstrap.min.js') }}"></script>*/
/*         <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->*/
/*         <script src="{{ asset('Bootstrap/js/ie10-viewport-bug-workaround.js') }}"></script>*/
/*         {% block javascripts %}{% endblock %}*/
/*     </body>*/
/* </html>*/
