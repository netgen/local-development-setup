# Configuration file for the Sphinx documentation builder.
#
# This file only contains a selection of the most common options. For a full
# list see the documentation:
# https://www.sphinx-doc.org/en/master/usage/configuration.html

# -- Path setup --------------------------------------------------------------

# If extensions (or modules to document with autodoc) are in another directory,
# add these directories to sys.path here. If the directory is relative to the
# documentation root, use os.path.abspath to make it absolute, like shown here.
#
# import os
# import sys
# sys.path.insert(0, os.path.abspath('.'))
import sys, os
import sphinx_rtd_theme

from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer
from pygments.lexers.web import HtmlLexer
from pygments.lexers.web import JsonLexer
from datetime import datetime
# -- Project information -----------------------------------------------------

project = "Netgen's Local Development Setup"
copyright = '2022, Netgen'
author = 'Netgen'

lexers['php'] = PhpLexer(startinline=True)
lexers['php-annotations'] = PhpLexer(startinline=True)
lexers['html'] = HtmlLexer(startinline=True)
lexers['json'] = JsonLexer(startinline=True)

extensions = ['sphinx.ext.autodoc',
    'sphinx.ext.doctest',
    'sphinx.ext.todo',
    'sphinx.ext.coverage',
    'sphinx.ext.imgmath',
    'sphinx.ext.ifconfig',
    'sensio.sphinx.configurationblock']

source_suffix = '.rst'
master_doc = 'index'

project = 'Netgen Layouts'
copyright = 'Netgen'
author = 'Netgen'

version = ''
release = ''

exclude_patterns = ['_build']

html_theme = "sphinx_rtd_theme"
html_theme_path = [sphinx_rtd_theme.get_html_theme_path()]

html_static_path = ['_static']
templates_path = ['_templates']

html_theme_options = {
    'collapse_navigation': True,
    'display_version': True,
}

html_context = {
    'copyright_url': 'https://netgen.io',
    'current_year': datetime.utcnow().year
}