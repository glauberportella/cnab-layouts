<?php
// gendoc.php - gerador de documentação para CNAB Layouts
// transforma YAML dos layouts em HTML

// Copyright (c) 2016 Glauber Portella <glauberportella@gmail.com>

// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the "Software"),
// to deal in the Software without restriction, including without limitation
// the rights to use, copy, modify, merge, publish, distribute, sublicense,
// and/or sell copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
// DEALINGS IN THE SOFTWARE.

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

if (count($argv) < 3) {
	die("\nUse: gendoc.php <arquivo YAML> <diretório para o HTML gerado>\n");
}

// Arquivo de origem a ser convertido
$src = $argv[1];

// Diretório onde salvar o HTML gerado
$dest = $argv[2];

$loader = new Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__.'/cache',
));

$layout = Yaml::parse(file_get_contents($src));

file_put_contents($dest, $twig->render('doc.html.twig', array('layout' => $layout)));