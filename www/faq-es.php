<?php
	include('config.php');
	include(mnminclude.'html1.php');
	do_header(_('FAQ') . ' | ' . _('factocheck'), '', false, false, '', false, false);
?>

<div id="singlewrap">
<div id="faq" class="faq">
<h1>Preguntas frecuentes</h1>
<br/>
<ul>
<li><h2>¿Qué es factocheck?</h2>
<p>Es un proyecto para crear una web con noticias que valide su autenticidad y ayude al mundo a descubrir la falsedad de la información, tan habitual en nuestros días.
Permite enviar noticias que serán revisadas por sus usuarios y votadas como verdaderas o falsas. Cuando un usuario envía una noticia ésta queda en la <a target="_blank" href="new"><em>cola de nuevas</em></a> hasta que reúne los votos suficientes para ser promovida a <a target="_blank" href="trending"><em>Tendencias</em></a>. Las que más actividad tengan aparecen en "Destacadas".
</p>
</li>

<li>
<h2>¿Hace falta registrarse?</h2>
<p>Es necesario para poder votar, enviar noticias y agregar comentarios.
</p>
</li>

<li>
<h2>¿Cómo enviar noticias?</h2>
<p>Debes <a target="_blank" href="register">registrarte</a> antes, es muy fácil y rápido. Hasta puedes usar redes sociales para hacerlo de forma inmediata con un solo clic. Luego seleccionas <a target="_blank" href="submit"><em>enviar noticia</em></a>. En un proceso de tres pasos simples la noticia será enviada a la <a target="_blank" href="queue">cola de nuevas</a>.
</p>
</li>


<li>
<h2>¿Qué tipos de noticias hay que enviar?</h2>
<p>Deben ser noticias Las que tú desees, pero piensa que estarán sujetas a la revisión de los lectores que las votarán, o no. Aún así, el objetivo principal es que se traten de noticias y apuntes de blogs. Lo que <strong>no debes hacer es <em>spam</em></strong>, es decir enviar muchos enlaces de unas pocas fuentes. Intenta ser variado. Envía noticias que puedan ser interesantes para muchos. No mires sólo tu ombligo, usa el <strong>sentido común y un mínimo de espíritu colaborativo y respeto hacia los demás</strong>.
</p>
</li>

<li>
<h2>¿Cómo funciona eso de los votos y el karma?</h2>
<p>En el wiki de Menéame está <a target="_blank" href="http://meneame.wikispaces.com/Karma">perfectamente explicado</a>.</p>
</li>

<li>
<h2>No puedo votar a comentarios o postits</h2>
<p>Hace falta un karma mínimo para votar comentarios y postits. Se pueden consultar los <a target="_blank" href="values">valores de los parámetros básicos</a> sobre karma y límites para más información sobre el tema.</p>
</li>


<li>
<h2>¿Cómo se seleccionan las noticias que aparecen en Tendencias?</h2>
<p>Lo hace un proceso que se ejecuta varias veces al día.</p>

<p>Primero calcula cuál es el karma mínimo que han de tener las noticias. Este valor depende de la media del karma de las noticias que fueron promovidas en los últimos días, más un coeficiente que depende del tiempo transcurrido desde la publicación de la última noticia. Este coeficiente decrece a medida que pasa el tiempo y se hace uno (1) cuando ha pasado una hora. Eso quiere decir que pasada una hora, cuando el coeficiente se hizo uno, cualquier noticia que tenga un karma igual o superior a la media será promovida. Esto hace que sean promovidas las noticias que tengan más votos y esos votos los haya recibido en un momento más cercano a su envío. El karma de cada noticia se calcula multiplicando el número de votos por el karma del autor del voto.
</p>
</li>

<li>
<h2><a name="we"></a>¿Quién está detrás del mediatize?</h2>
<p>Es un proyecto para crear una web con noticias que valide su autenticidad y ayude al mundo a descubrir la falsedad de la información, tan habitual en nuestros días.
Encontrarás los datos de <strong>contacto</strong> en <a target="_blank" href="legal#contact">la página de las condiciones legales</a>.
</p>
</li>

<li>
<h2>¿Qué software se usa?</h2>
<p>El software comenzó a desarrollarlo Ricardo Galli y Benjamí Villoslada con colaboraciones de terceros, más las modificaciones hechas por Fermín Molina para otro agregador llamado <a href="https://www.mediatize.info" target="_blank">mediatize</a>, y que a su vez fue modificado para hacer "factocheck".</p>
</li>

<li>
<h2>¿Será liberado el software?</h2>
<p>Ya está liberado. En el pie de todas las páginas encontrarás el enlace para descargarlo. Tiene la licencia <a target="_blank" href="http://www.affero.org/oagpl.html">Affero General Public License</a>.</p>
</li>

<li>
<h2>¿Dónde notificamos errores, problemas o sugerencias?</h2>
<p>Ver la <a target="_blank" href="legal#contact">sección de contacto</a> en la condiciones legales y de uso.
</p>
</li>

</ul>

</div>
</div>

<?php

do_footer();

