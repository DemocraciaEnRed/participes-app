<?php

use App\Faq;
use Illuminate\Database\Seeder;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // general
        //------
        $faq = new Faq();
        $faq->title = '¿Qué es Partícipes Digital?';
        $faq->section = 'general';
        $faq->order = 1;
        $faq->content = '<p>Es una plataforma de monitoreo ciudadano que te permite hacer seguimiento de objetivos y metas de gobiernos.</p>';
        $faq->save();
        //------
        $faq = new Faq();
        $faq->title = '¿Quíenes somos Partícipes?';
        $faq->section = 'general';
        $faq->order = 2;
        $faq->content = '<p>Somos una red de organizaciones que creemos en la importancia de un gobierno abierto. Es por eso que relevamos políticas públicas en nuestra ciudad, apoyados en reportes constantes y organizados.</p>';
        $faq->save();
        //------
        $faq = new Faq();
        $faq->title = '¿Como participo?';
        $faq->section = 'general';
        $faq->order = 3;
        $faq->content = '<p>Partícipes digital está dirigido a organizaciones de la sociedad civil y ciudadanía interesada y comprometida en el monitoreo ciudadano de las problemáticas públicas de sus ciudades, con el fin de generar incidencia.</p> <p><b>Informate</b> sobre monitoreos de políticas públicas realizados por organizaciones de la sociedad civil y ciudadanía de forma sencilla y colaborativa.</p> <p><b>Validá</b> la información sobre avances de metas o compromisos de gobierno, comentaá y sumate a comunidades temáticas.</p><p><b>Involucrate:</b> Conectate con otros actores de la sociedad civil y potencia tu capacidad de incidencia.</p>';
        $faq->save();
        //------
        $faq = new Faq();
        $faq->title = 'Más allá de nuestra ciudad';
        $faq->section = 'general';
        $faq->order = 4;
        $faq->content = '<p>Esta plataforma surge del proyecto Partícipes de fortalecimiento de procesos de rendición de cuentas en Córdoba, Buenos Aires, Rosario y Mendoza a través del monitoreo ciudadano de políticas públicas, facilitado por el uso de herramientas tecnológicas y nuevos canales de comunicación. Este proyecto es coordinado por la Fundación Avina y es financiado por la Unión Europea.</p>';
        $faq->save();
        //------
        // faq
        //------
        $faq = new Faq();
        $faq->title = 'Preguntas Frecuentes';
        $faq->section = 'faq';
        $faq->order = 1;
        $faq->content = '<h6>¿Qué es el monitoreo ciudadano? </h6> <p>Es una forma de participación ciudadana que consiste en la realización de ejercicios sistemáticos, independientes y planificados para observar, dar seguimiento y proponer mejoras a  problemáticas públicas.</p> <h6>¿Quién carga la información en Partícipes?</h6> <p>La información es actualizada por referentes de diversas organizaciones que monitorean agendas de interés.</p> <h6>¿Cómo funciona?</h6> <p>Referentes de organizaciones cargan objetivos y metas de políticas públicas locales de interés y se comprometen a hacer reportes informando el estado y los avances de estas políticas.</p> <p>Hay cuatro estados para las metas: inactiva, en progreso, no cumplidas y finalizada.</p> <h6>¿Puedo hacer monitoreos?</h6> <p>Si estás interesado en comprometerse y voluntariarte para hacer monitoreo escribinos a xxxx @xxxx  </p> <h6>¿Por qué es necesario Partícipes?</h6> <p>Creemos que estas prácticas promueven una ciudadanía activa, colaboran con una mejor relación entre gobierno sociedad, ayudan a mejorar las políticas, construir un Estado más transparente y permite tener información para  incidir en las políticas públicas.</p>';
        $faq->save();
        //------
        $faq = new Faq();
        $faq->title = 'Manual de usuario';
        $faq->section = 'faq';
        $faq->order = 2;
        $faq->content = '<p>A completar...</p>';
        $faq->save();
        //------
        // legal
        //------
        $faq = new Faq();
        $faq->title = 'Terminos y condiciones';
        $faq->section = 'legal';
        $faq->order = 1;
        $faq->content = '<p>Los siguientes Términos y Condiciones regulan el uso de la Plataforma [Nombre de la plataforma] donde se brinda información sobre [Intención de la plataforma]</p><p>El registro y uso de la plataforma por parte de los usuarios indica la aceptación absoluta de los Términos y Condiciones presentes y de la Política de Privacidad.</p><p>La plataforma [Nombre de la plataforma] es un sitio web que promueve la democracia interna [Nombre de la plataforma]. Esta herramienta favorece la generación de espacios de colaboración para co-diseñar y co-producir valor público.</p><h4><strong>Inscripción en la plataforma web</strong></h4><p>El acceso al Sitio Web es libre y gratuito. Requiere inscripción previa a través de un formulario que deberá ser validado por la administración del sitio.</p><p>La información personal suministrada por la/el Usuaria/o al momento de inscribirse en el Sitio Web está protegida con una clave, y sólo podrá ser modificada por el mismo Usuario. El Sitio Web se reserva el derecho de realizar validaciones en relación a la información brindada por el Usuario al momento de la inscripción. En caso de que la información brindada no pueda validarse, el Administrador se reserva el derecho de no dar de alta a ese Usuario. El Sitio Web está destinado únicamente a Usuarios mayores de 16 años cumplidos, de modo que cualquier registro de uso o acceso al Sitio Web por cualquier menor de esa edad no está autorizado. El Usuario garantiza y declara ser mayor de 16 años. Por su parte, el Administrador deslinda su responsabilidad en el caso de no ser veraz la información suministrada al respecto.</p><p>Al momento de la inscripción el Usuario asume el compromiso y la responsabilidad de:</p><ul><li><p>No proporcionar información personal falsa ni crear cuentas a nombre de terceros sin su autorización.</p></li><li><p>No crear más de una cuenta personal.</p></li><li><p>No crear otra cuenta sin permiso expreso del Administrador, en caso de que este último haya inhabilitado la cuenta original.</p></li><li><p>Mantener la información de contacto exacta y actualizada.</p></li><li><p>No compartir la contraseña ni permitir a otra persona acceda a su cuenta.</p></li><li><p>El Usuario se compromete a notificar al Administrador ante cualquier uso no autorizado de su clave.</p></li></ul><p>El Administrador se reserva el derecho de rechazar cualquier solicitud de inscripción o de cancelar un registro previamente aceptado.</p><h4><strong>Usuarios, obligaciones y condiciones</strong></h4><p>El Usuario deberá respetar estos Términos y Condiciones de Uso del Sitio Web. Las infracciones por acción u omisión de los presentes Términos y Condiciones de Uso generarán el derecho a favor del Administrador de suspender al Usuario que las haya realizado.</p><p>El Usuario es el único responsable del contenido que suba, publique o muestre en el Sitio Web, garantizando que el mismo no infringe derechos de terceros ni los Términos y Condiciones de Uso ni viola ninguna ley, reglamento u otra normativa. El Usuario entiende y acepta que el material y/o contenido que suba y/o publique podría ser utilizado por otros Usuarios del Sitio Web y/o por terceras personas ajenas, y que el Administrador del Sitio Web no será responsable en ningún caso por tales utilizaciones.</p><p>El Usuario se obliga a usar el Sitio Web de conformidad con estos Términos y Condiciones, en forma correcta y lícita. En caso contrario, el Sitio Web podrá retirar el contenido y/o suspender la cuenta del Usuario, por considerarlo: violatorio de estos Términos y Condiciones y/o de la Política de Privacidad de este Sitio Web, ofensivo, ilegal, violatorio de derechos de terceros, contrario a la moral y buenas costumbres y amenaza la seguridad de otros Usuarios.</p><p>Sin embargo, esta posibilidad no implica necesariamente que el contenido de toda la información disponible en el Sitio Web haya sido revisado.</p><p>El Usuario responderá por los daños y perjuicios de toda naturaleza que el Sitio Web pueda sufrir, directa o indirectamente, como consecuencia del incumplimiento de cualquiera de las cláusulas derivadas de estos Términos y Condiciones de Uso.</p><p>El Sitio Web no controla ni garantiza la ausencia de virus u otros softwares de tipo destructivo en el material descargable puesto a disposición por los Usuarios.</p><p>En relación a los aportes, colaboraciones, comentarios y votaciones que los Usuarios realicen con respecto a las iniciativas propuestas en el Sitio Web, las mismas NO son de carácter vinculante, obligatorio y/o impositivo sobre el documento final.</p><p>La adecuada utilización de todos los recursos de Internet es, sin excepción, de entera responsabilidad del Usuario del Sitio Web.</p><h4><strong>Actividades Prohibidas</strong></h4><p>Las siguientes actividades, sean lícitas o ilícitas, se encuentran expresamente vedadas, sin perjuicio de las prohibiciones generales expuestas anteriormente:</p><ul><li><p>Hostigar, acosar, amenazar, acechar, realizar actos de vandalismo hacia otros Usuarios.</p></li><li><p>Infringir los derechos a la intimidad de otros Usuarios.</p></li><li><p>Solicitar información personal identificable de otros Usuarios con el propósito de hostigar, atacar, explotar, violar la intimidad de los mismos;</p></li><li><p>Publicar de manera intencionada o con conocimiento injurias o calumnias;</p></li><li><p>Publicar, con el intento de engañar, contenido que es falso o inexacto;</p></li><li><p>Intentar usurpar la identidad de otro Usuario, representando de manera falsa su afiliación con cualquier individuo o entidad, o utilizar el nombre de otro Usuario con el propósito de engañar;</p></li><li><p>Promover, defender o mostrar pornografía, obscenidad, vulgaridad, blasfemia, odio, fanatismo, racismo y/o violencia. En caso de sufrir alguna de estas situaciones, comunicarse con el Administrador a través de [Nombre de la plataforma]</p></li><li><p>Vulnerar los derechos establecidos en la Ley N° 25.326 de Protección de Datos Personales.</p></li></ul><h4><strong>Moderación de las iniciativas</strong></h4><p>Cada iniciativa/propuesta publicada en el Sitio Web tendrá un moderador responsable de hacer cumplir estos Términos y Condiciones de uso. El moderador será designado por el organismo originante de la propuesta.</p><p>Fomentamos un diálogo franco y abierto, pero manteniendo el nivel de la discusión, evitando afrentas a personas o instituciones, material comercial no relacionado (SPAM) u otros desvíos de la intención original del Sitio Web.</p><h4><strong>Ley aplicable y jurisdicción del Sitio Web.</strong></h4><p>Los Términos y Condiciones de Uso aquí presentados se rigen por las leyes de la República Argentina. El Administrador y el Usuario se someten a los Tribunales Nacionales en lo Contencioso Administrativos con asiento en la Ciudad Autónoma de Buenos Aires.</p>';
        $faq->save();
        //------
        $faq = new Faq();
        $faq->title = 'Políticas de privacidad';
        $faq->section = 'legal';
        $faq->order = 2;
        $faq->content = '<p>La recolección y tratamiento automatizado de los datos personales tiene como finalidad el buen y fluido mantenimiento de la relación establecida entre el Usuario y el Administrador.</p> <p>El Administrador garantiza la debida protección integral de los datos personales almacenados en el Sitio Web así como también el acceso a la información que sobre el mismo se registre, de conformidad a lo establecido en el artículo 43, párrafo tercero de la Constitución Nacional y la Ley N° 25.326 de Protección de los Datos Personales.</p> <p>Los Usuarios se comprometen a notificar de inmediato al Sitio Web sobre uso no autorizado de su cuenta o cualquier otra situación que pudiera ir contra la seguridad del sitio, como así también de casos de cyberbullying, cyberstalking, cibergrooming y/o cualquier otra situación de hostigamiento, discriminación, acoso, etc.</p>';
        $faq->save();
    }
}
