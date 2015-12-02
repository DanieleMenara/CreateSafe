<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_d46c076a5eee7ece2e40ca297d8e702157d263e975a8d51a2b8fab72eee54754 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_90a83a79285a252de447d9707f5f6d02eb6151a688ab4fe0189ffd9fe3ef1a78 = $this->env->getExtension("native_profiler");
        $__internal_90a83a79285a252de447d9707f5f6d02eb6151a688ab4fe0189ffd9fe3ef1a78->enter($__internal_90a83a79285a252de447d9707f5f6d02eb6151a688ab4fe0189ffd9fe3ef1a78_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_90a83a79285a252de447d9707f5f6d02eb6151a688ab4fe0189ffd9fe3ef1a78->leave($__internal_90a83a79285a252de447d9707f5f6d02eb6151a688ab4fe0189ffd9fe3ef1a78_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_ee61fbedcec222ebf34238e1afb2696caa801c9fa4d625d5e95b8e9a2eda5af4 = $this->env->getExtension("native_profiler");
        $__internal_ee61fbedcec222ebf34238e1afb2696caa801c9fa4d625d5e95b8e9a2eda5af4->enter($__internal_ee61fbedcec222ebf34238e1afb2696caa801c9fa4d625d5e95b8e9a2eda5af4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_ee61fbedcec222ebf34238e1afb2696caa801c9fa4d625d5e95b8e9a2eda5af4->leave($__internal_ee61fbedcec222ebf34238e1afb2696caa801c9fa4d625d5e95b8e9a2eda5af4_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_70deafe0aa8d4125757ddbfbe8e3a5c27e5b104712e8a12242e8b012414584a4 = $this->env->getExtension("native_profiler");
        $__internal_70deafe0aa8d4125757ddbfbe8e3a5c27e5b104712e8a12242e8b012414584a4->enter($__internal_70deafe0aa8d4125757ddbfbe8e3a5c27e5b104712e8a12242e8b012414584a4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_70deafe0aa8d4125757ddbfbe8e3a5c27e5b104712e8a12242e8b012414584a4->leave($__internal_70deafe0aa8d4125757ddbfbe8e3a5c27e5b104712e8a12242e8b012414584a4_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_3f996a3b69d3935a545507463459b6fb94fc90843b4ddab85d315347afd0262c = $this->env->getExtension("native_profiler");
        $__internal_3f996a3b69d3935a545507463459b6fb94fc90843b4ddab85d315347afd0262c->enter($__internal_3f996a3b69d3935a545507463459b6fb94fc90843b4ddab85d315347afd0262c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_3f996a3b69d3935a545507463459b6fb94fc90843b4ddab85d315347afd0262c->leave($__internal_3f996a3b69d3935a545507463459b6fb94fc90843b4ddab85d315347afd0262c_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends 'TwigBundle::layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include 'TwigBundle:Exception:exception.html.twig' %}*/
/* {% endblock %}*/
/* */
