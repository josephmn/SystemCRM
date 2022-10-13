using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using Newtonsoft.Json.Serialization;
using Newtonsoft.Json;
using WSRecursos.view;
using WSRecursos.Entity;


namespace WSRecursos
{
    /// <summary>
    /// Descripción breve de WSRecursos
    /// </summary>
    [WebService(Namespace = "http://www.mundoaltomayo.com/")]
    [WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    [System.ComponentModel.ToolboxItem(false)]
    // Para permitir que se llame a este servicio web desde un script, usando ASP.NET AJAX, quite la marca de comentario de la línea siguiente. 
    // [System.Web.Script.Services.ScriptService]
    public class WSRecursos : System.Web.Services.WebService
    {
        // WEB1
        public VLogin obELogin = new VLogin();
        public VMenu obEMenu = new VMenu();
        public VSubMenu obESubMenu = new VSubMenu();
        public VConfiguracionCorreo obEConfiguracionCorreo = new VConfiguracionCorreo();

        public VCivil obECivil = new VCivil();
        public VTipoTrabajador obETipoTrabajador = new VTipoTrabajador();
        public VOcupacion obEOcupacion = new VOcupacion();
        public VTipoContrato obETipoContrato = new VTipoContrato();
        public VTipoPago obETipoPago = new VTipoPago();
        public VSolicitudvacaciones obESolicitudvacaciones = new VSolicitudvacaciones();

        public VAsistencia obEAsistencia = new VAsistencia();
        public VAsistenciadni obEAsistenciadni = new VAsistenciadni();

        public VBoletapago obEBoletapago = new VBoletapago();
        public VBoletacabecera obEBoletacabecera = new VBoletacabecera();
        public VBoletadetalle obEBoletadetalle = new VBoletadetalle();

        public VMantPerfilPersonal obEMantPerfilPersonal = new VMantPerfilPersonal();
        public VMantFotoPerfil obEMantFotoPerfil = new VMantFotoPerfil();
        public VConsultaPerfil obEConsultaPerfil = new VConsultaPerfil();

        public VMantPassword obEMantPassword = new VMantPassword();
        public VRecuperarCorreo obERecuperarCorreo = new VRecuperarCorreo();
        public VMantFirma obEMantFirma = new VMantFirma();

        public VListarvacacionesxdni obEListarvacacionesxdni = new VListarvacacionesxdni();
        public VMantVacaciones obEMantVacaciones = new VMantVacaciones();
        public VMantCronograma obEMantCronograma = new VMantCronograma();
        public VListarcronogramaxmes obEListarcronogramaxmes = new VListarcronogramaxmes();
        public VListarmeses obEListarmeses = new VListarmeses();
        public VListadocontrolvacacionesjefe obEListadocontrolvacacionesjefe = new VListadocontrolvacacionesjefe();
        public VGestionVacaciones obEGestionVacaciones = new VGestionVacaciones();

        public VVerificardocumento obEVerificardocumento = new VVerificardocumento();
        public VConsultarCronograma obEConsultarCronograma = new VConsultarCronograma();

        public VConsultaVacacionedni obEConsultaVacacionedni = new VConsultaVacacionedni();
        public VListadoEstadocronograma obEListadoEstadocronograma = new VListadoEstadocronograma();
        public VImpVacacioncronograma obEImpVacacioncronograma = new VImpVacacioncronograma();

        public VMantVacacionesanhio obEMantVacacionesanhio = new VMantVacacionesanhio();
        public VConsultarmeses obEConsultarmeses = new VConsultarmeses();

        public VCertificadoUtilidades obECertificadoUtilidades = new VCertificadoUtilidades();
        public VCertificadoCts obECertificadoCts = new VCertificadoCts();

        public VListarBoletapago obEListarBoletapago = new VListarBoletapago();
        public VListarUtilidades obEListarUtilidades = new VListarUtilidades();
        public VListarCTS obEListarCTS = new VListarCTS();

        public VListarBoletin obEListarBoletin = new VListarBoletin();
        public VListarCalendario obEListarCalendario = new VListarCalendario();

        public VMantLogBoletas obEMantLogBoletas = new VMantLogBoletas();
        public VMantLogUtilidades obEMantLogUtilidades = new VMantLogUtilidades();
        public VMantLogCTS obEMantLogCTS = new VMantLogCTS();

        public VListarSweetAlert obEListarSweetAlert = new VListarSweetAlert();
        public VListarToast obEListarToast = new VListarToast();

        public VListadoDocumentosPersonal obEListadoDocumentosPersonal = new VListadoDocumentosPersonal();
        public VCombodocumentos obECombodocumentos = new VCombodocumentos();
        public VListatipodocumento obEListatipodocumento = new VListatipodocumento();
        public VMantDocumentos obEMantDocumentos = new VMantDocumentos();

        //WEB2
        public VPais obEPais = new VPais();
        public VDepartamento obEDepartamento = new VDepartamento();
        public VProvincia obEProvincia = new VProvincia();
        public VDistrito obEDistrito = new VDistrito();
        public VCentroCosto obECentroCosto = new VCentroCosto();
        public VCuenta obECuenta = new VCuenta();
        public VArea obEArea = new VArea();
        public VSubArea obESubArea = new VSubArea();
        public VCargo obECargo = new VCargo();
        public VLocalTrabajo obELocalTrabajo = new VLocalTrabajo();
        public VEntidadFinanciera obEEntidadFinanciera = new VEntidadFinanciera();

        public VEmpresa obEEmpresa = new VEmpresa();
        public VZona obEZona = new VZona();
        public VLocal obELocal = new VLocal();
        public VTurno obETurno = new VTurno();
        public VSemana obESemana = new VSemana();
        public VTurnoDetalle obETurnoDetalle = new VTurnoDetalle();
        public VComision obEComision = new VComision();

        public VPersonal obEPersonal = new VPersonal();
        public VGrupoArea obEGrupoArea = new VGrupoArea();
        public VGrupoCargo obEGrupoCargo = new VGrupoCargo();

        public VMantIndicadorPersonal obEMantIndicadorPersonal = new VMantIndicadorPersonal();

        // INDICADORES
        public VIndHeadcount obEIndHeadcount = new VIndHeadcount();
        public VIndDotacion obEIndDotacion = new VIndDotacion();
        public VIndHeadcountArea obEIndHeadcountArea = new VIndHeadcountArea();
        public VIndDotacionArea obEIndDotacionArea = new VIndDotacionArea();
        public VIndHeadcountCargo obEIndHeadcountCargo = new VIndHeadcountCargo();
        public VIndDotacionCargo obEIndDotacionCargo = new VIndDotacionCargo();
        public VIndAusentismo obEIndAusentismo = new VIndAusentismo();
        public VIndAusentismorem obEIndAusentismorem = new VIndAusentismorem();
        public VIndAusentismonorem obEIndAusentismonorem = new VIndAusentismonorem();
        public VIndAusentismoxArea obEIndAusentismoxArea = new VIndAusentismoxArea();
        public VIndAusentismoxCargo obEIndAusentismoxCargo = new VIndAusentismoxCargo();
        public VIndHE obEIndHE = new VIndHE();
        public VIndHESoles obEIndHESoles = new VIndHESoles();
        public VIndHExPersona obEIndHExPersona = new VIndHExPersona();
        public VIndHExMontos obEIndHExMontos = new VIndHExMontos();

        // otros
        public VMantZona obEMantZona = new VMantZona();
        public VMantLocal obEMantLocal = new VMantLocal();
        public VMantTurno obEMantTurno = new VMantTurno();
        public VMantTurnoDetalle obEMantTurnoDetalle = new VMantTurnoDetalle();

        public VSolicitudComision obESolicitudComision = new VSolicitudComision();
        public VMantMeses obEMantMeses = new VMantMeses();

        public VConPerfiles obEConPerfiles = new VConPerfiles();
        public VConPerfilesAccesos obEConPerfilesAccesos = new VConPerfilesAccesos();

        public VMantPerfilesAccesos obEMantPerfilesAccesos = new VMantPerfilesAccesos();
        public VMantPerfiles obEMantPerfiles = new VMantPerfiles();

        public VListarUsuarios obEListarUsuarios = new VListarUsuarios();
        public VMantUsuario obEMantUsuario = new VMantUsuario();

        public VListarJefes obEListarJefes = new VListarJefes();
        public VListarAsistentes obEListarAsistentes = new VListarAsistentes();
        public VMantJefeAsistente obEMantJefeAsistente = new VMantJefeAsistente();

        public VPeriodosBoletas obEPeriodosBoletas = new VPeriodosBoletas();
        public VMantPeriodosBoletas obEMantPeriodosBoletas = new VMantPeriodosBoletas();

        public VMantUserPassword obEMantUserPassword = new VMantUserPassword();
        public VActualizacionDatos obEActualizacionDatos = new VActualizacionDatos();

        //CONSULTA PARA RECLUTAMIENTO
        public VConsultaFinalistas obEConsultaFinalistas = new VConsultaFinalistas();
        public VConsultaPaPersonal obEConsultaPaPersonal = new VConsultaPaPersonal();
        public VMantRegPersonal obEMantRegPersonal = new VMantRegPersonal();

        //EVALUACIONES
        public VEvaluacionPersona obEvaluacionPersona = new VEvaluacionPersona();

        //BENEFICIOS
        public VListarConvenios obEListarConvenios = new VListarConvenios();
        public VListarConveniosEducativos obEListarConveniosEducativos = new VListarConveniosEducativos();
        public VMantConvenios obEMantConvenios = new VMantConvenios();
        public VMantConveniosTexto obEMantConveniosTexto = new VMantConveniosTexto();        
        public VListarConveniosTexto obEListarConveniosTexto = new VListarConveniosTexto();              
        public VListarDisenioTexto obEListarDisenioTexto = new VListarDisenioTexto();   
        public VMantConveniosEducativos obEMantConveniosEducativos = new VMantConveniosEducativos();

        //FLEX TIME
        public VListarFlexTime obEListarFlexTime = new VListarFlexTime();
        public VMantFlexTime obEMantFlexTime = new VMantFlexTime();
        public VTablaFlexTime obETablaFlexTime = new VTablaFlexTime();
        public VMantTablaFlexTime obEMantTablaFlexTime = new VMantTablaFlexTime();
        public VControlFlexTime obEControlFlexTime = new VControlFlexTime();
        public VMantControlFlexTime obEMantControlFlexTime = new VMantControlFlexTime();

        //REMOTO
        public VTablaRemoto obETablaRemoto = new VTablaRemoto();
        public VMantTablaRemoto obEMantTablaRemoto = new VMantTablaRemoto();
        public VControlRemoto obEControlRemoto = new VControlRemoto();
        public VMantControlRemoto obEMantControlRemoto = new VMantControlRemoto();
        
        // REVISAR SI TIENE ACCESO A MARCAR REMOTO
        public VGetMarcacion obEGetMarcacion = new VGetMarcacion();
        public VMantMensajeMarcacion obEMantMensajeMarcacion = new VMantMensajeMarcacion();
        public VMantMarcacion obEMantMarcacion = new VMantMarcacion();

        //FERIADO
        public VListarFeriado obEListarFeriado = new VListarFeriado();
        public VMantFeriado obEMantFeriado = new VMantFeriado();

        //VACACIONES CUMPLEAÑOS
        public VListarcumpleaniosxdni obEListarcumpleaniosxdni = new VListarcumpleaniosxdni();
        public VMantVacacioncumpleanios obEMantVacacioncumpleanios = new VMantVacacioncumpleanios();
        public VListadovacacionescumplejefe obEListadovacacionescumplejefe = new VListadovacacionescumplejefe();

        //INVENTARIO
        public VListarInventario obEListarInventario = new VListarInventario();
        public VGetInventario obEGetInventario = new VGetInventario();
        public VMantInventario obEMantInventario = new VMantInventario();

        //LOG CORREOS
        public VMantLogCorreos obEMantLogCorreos = new VMantLogCorreos();

        //GUARDAR VENTA
        public VMantVentaCabecera obEMantVentaCabecera = new VMantVentaCabecera();
        public VMantVentaDetalle obEMantVentaDetalle = new VMantVentaDetalle();
        public VListarTopeVentas obEListarTopeVentas = new VListarTopeVentas();

        //NOTIFICACIONES
        public VListarNotificaciones obEListarNotificaciones = new VListarNotificaciones();
        public VMantNotificaciones obEMantNotificaciones = new VMantNotificaciones();
        public VListarPaNotificaciones obEListarPaNotificaciones = new VListarPaNotificaciones();
        public VMantNotificacionesPersonal obEMantNotificacionesPersonal = new VMantNotificacionesPersonal();

        //BUZON DE SUGERENCIA
        public VListarBuzonsugerencia obEListarBuzonsugerencia = new VListarBuzonsugerencia();
        public VMantLogCorreosBuzonsugerencia obEMantLogCorreosBuzonsugerencia = new VMantLogCorreosBuzonsugerencia();
        public VListarCorreoBuzonsugerencia obEListarCorreoBuzonsugerencia = new VListarCorreoBuzonsugerencia();

        //TIPOS Y CONFIGURACION DE ARCHIVOS
        public VListarTipoArchivos obEListarTipoArchivos = new VListarTipoArchivos();
        public VMantArchivos obEMantArchivos = new VMantArchivos();
        public VMantArchivosLegajo obEMantArchivosLegajo = new VMantArchivosLegajo();

        //CANAL DE DENUNCIA
        public VMantLogCorreosCanaldenuncia obEMantLogCorreosCanaldenuncia = new VMantLogCorreosCanaldenuncia();

        //NOTIFICACION CUMPLEAÑOS
        public VListarNotificumpleanios obEListarNotificumpleanios = new VListarNotificumpleanios();
        public VMantNotificumpleanios obEMantNotificumpleanios = new VMantNotificumpleanios();
        public VListarNotificumpleTexto obEListarNotificumpleTexto = new VListarNotificumpleTexto();
        public VListarDisenioNotificumpleTexto obEListarDisenioNotificumpleTexto = new VListarDisenioNotificumpleTexto();
        public VMantNotificumpleaniosTexto obEMantNotificumpleaniosTexto = new VMantNotificumpleaniosTexto();

        //PAGO VACACIONES
        public VListarpagovacaciones obEListarpagovacaciones = new VListarpagovacaciones();
        public VMantPagovacaciones obEMantPagovacaciones = new VMantPagovacaciones();
        public VListarenviovacaciones obEListarenviovacaciones = new VListarenviovacaciones();
        public VListaReportePagoVacaciones obEListaReportePagoVacaciones = new VListaReportePagoVacaciones();

        //WEB1
        [WebMethod]
        public string Login(String usuario, String password)
        {
            List<ELogin> lista = new List<ELogin>();
            lista = obELogin.Login(usuario, password);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarMenu(Int32 dato)
        {
            List<EMenu> lista = new List<EMenu>();
            lista = obEMenu.Menu(dato);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarSubMenu(Int32 dato)
        {
            List<ESubMenu> lista = new List<ESubMenu>();
            lista = obESubMenu.SubMenu(dato);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoCivil()
        {
            List<ECivil> lista = new List<ECivil>();
            lista = obECivil.Civil();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoTipoTrabajador()
        {
            List<ETipoTrabajador> lista = new List<ETipoTrabajador>();
            lista = obETipoTrabajador.TipoTrabajador();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoOcupacion()
        {
            List<EOcupacion> lista = new List<EOcupacion>();
            lista = obEOcupacion.Ocupacion();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoTipoContrato()
        {
            List<ETipoContrato> lista = new List<ETipoContrato>();
            lista = obETipoContrato.TipoContrato();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoTipoPago()
        {
            List<ETipoPago> lista = new List<ETipoPago>();
            lista = obETipoPago.TipoPago();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoArea()
        {
            List<EArea> lista = new List<EArea>();
            lista = obEArea.Area();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoSubArea(Int32 post, String area)
        {
            List<ESubArea> lista = new List<ESubArea>();
            lista = obESubArea.SubArea(post, area);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoCargo()
        {
            List<ECargo> lista = new List<ECargo>();
            lista = obECargo.Cargo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoLocalTrabajo()
        {
            List<ELocalTrabajo> lista = new List<ELocalTrabajo>();
            lista = obELocalTrabajo.LocalTrabajo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoEntidadFinanciera()
        {
            List<EEntidadFinanciera> lista = new List<EEntidadFinanciera>();
            lista = obEEntidadFinanciera.EntidadFinanciera();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoDocumentosPersonal(String dni)
        {
            List<EListadoDocumentosPersonal> lista = new List<EListadoDocumentosPersonal>();
            lista = obEListadoDocumentosPersonal.Listar_ListadoDocumentosPersonal(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listacombodocumentos(Int32 post, Int32 id, String dni)
        {
            List<ECombodocumentos> lista = new List<ECombodocumentos>();
            lista = obECombodocumentos.Listar_Combodocumentos(post, id, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listatipodocumento(Int32 id)
        {
            List<EListatipodocumento> lista = new List<EListatipodocumento>();
            lista = obEListatipodocumento.Listar_Listatipodocumento(id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoDocumentos(String id, Int32 codigo, String dni, String directorio, String mime, String type)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantDocumentos.MantDocumentos(id, codigo, dni, directorio, mime, type);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string solicitudvacaciones(String dateinicio, String datefin, String dni, Int32 tipovac)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obESolicitudvacaciones.Solicitudvacaciones(dateinicio, datefin, dni, tipovac);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listadoasistencia(String finicio, String ffin)
        {
            List<EAsistencia> lista = new List<EAsistencia>();
            lista = obEAsistencia.Listar_Asistencia(finicio, ffin);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listadoasistenciadni(String dni, String finicio, String ffin)
        {
            List<EAsistenciadni> lista = new List<EAsistenciadni>();
            lista = obEAsistenciadni.Listar_Asistenciadni(dni, finicio, ffin);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listaboletapago(String dni)
        {
            List<EBoletapago> lista = new List<EBoletapago>();
            lista = obEBoletapago.Listar_Boletapago(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listaboletacabecera(String nroboleta)
        {
            List<EBoletacabecera> lista = new List<EBoletacabecera>();
            lista = obEBoletacabecera.Listar_Boletacabecera(nroboleta);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listaboletadetalle(String nroboleta)
        {
            List<EBoletadetalle> lista = new List<EBoletadetalle>();
            lista = obEBoletadetalle.Listar_Boletadetalle(nroboleta);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoPerfilPersonal(String dni, String nombre, String fnacimiento,
            Int32 civil, String celular, String correo, String correoempresa, String celularsos, String nombresos,
            String departamento, String provincia, String distrito, String domicilioactual, String referencia, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantPerfilPersonal.MantPerfilPersonal(dni, nombre, fnacimiento, civil, celular, correo,
                        correoempresa, celularsos, nombresos, departamento, provincia, distrito, domicilioactual, referencia, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoFotoperfil(String dni, String nombre, String ruta)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantFotoPerfil.MantFotoPerfil(dni, nombre, ruta);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarConsultaPerfil(String dni)
        {
            List<EConsultaPerfil> lista = new List<EConsultaPerfil>();
            lista = obEConsultaPerfil.Listar_ConsultaPerfil(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoPassword(String dni, String password)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantPassword.MantPassword(dni, password);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoFirma(String dni, String nombre, String ruta)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantFirma.MantFirma(dni, nombre, ruta);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarRecuperarCorreo(String correo)
        {
            List<ERecuperarCorreo> lista = new List<ERecuperarCorreo>();
            lista = obERecuperarCorreo.Listar_RecuperarCorreo(correo);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listarvacacionesxdni(String dni)
        {
            List<EListarvacacionesxdni> lista = new List<EListarvacacionesxdni>();
            lista = obEListarvacacionesxdni.Listar_Listarvacacionesxdni(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoVacaciones(String id, Int32 codigo, String dni, String indice)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantVacaciones.MantVacaciones(id, codigo, dni, indice);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoCronograma(Int32 post, Int32 codigo, String dni, Int32 mes, Int32 tipo, Int32 dias, Int32 anhio, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantCronograma.MantCronograma(post, codigo, dni, mes, tipo, dias, anhio, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listarcronogramaxmes (Int32 mes, Int32 anhio)
        {
            List<EListarcronogramaxmes> lista = new List<EListarcronogramaxmes>();
            lista = obEListarcronogramaxmes.Listar_Listarcronogramaxmes(mes, anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listarmeses(Int32 post)
        {
            List<EListarmeses> lista = new List<EListarmeses>();
            lista = obEListarmeses.Listar_Listarmeses(post);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listadocontrolvacacionesjefe(String dni, String finicio, String ffin)
        {
            List<EListadocontrolvacacionesjefe> lista = new List<EListadocontrolvacacionesjefe>();
            lista = obEListadocontrolvacacionesjefe.Listar_Listadocontrolvacacionesjefe(dni, finicio, ffin);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string GestionVacaciones(Int32 codigo, String dni, Int32 indice)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEGestionVacaciones.Listar_GestionVacaciones(codigo, dni, indice);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Verificardocumento(String dni)
        {
            List<EVerificardocumento> lista = new List<EVerificardocumento>();
            lista = obEVerificardocumento.Listar_Verificardocumento(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Consultarcronograma(Int32 codigo)
        {
            List<EConsultarCronograma> lista = new List<EConsultarCronograma>();
            lista = obEConsultarCronograma.Listar_ConsultarCronograma(codigo);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listavacacionesdni(Int32 post, Int32 id)
        {
            List<EConsultaVacacionedni> lista = new List<EConsultaVacacionedni>();
            lista = obEConsultaVacacionedni.Listar_ConsultaVacacionedni(post, id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoEstadocronograma()
        {
            List<EListadoEstadocronograma> lista = new List<EListadoEstadocronograma>();
            lista = obEListadoEstadocronograma.Listar_ListadoEstadocronograma();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ImpVacacioncronograma(Int32 id, Int32 anhio)
        {
            List<EImpVacacioncronograma> lista = new List<EImpVacacioncronograma>();
            lista = obEImpVacacioncronograma.Listar_ImpVacacioncronograma(id, anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoVacacionesanhio(Int32 anhio, string user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantVacacionesanhio.MantVacacionesanhio(anhio, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Consultarmeses(Int32 id)
        {
            List<EConsultarmeses> lista = new List<EConsultarmeses>();
            lista = obEConsultarmeses.Listar_Consultarmeses(id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoMeses(Int32 id, Int32 estado, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantMeses.MantMeses(id, estado, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string CertificadoUtilidades(Int32 anhio, String dni)
        {
            List<ECertificadoUtilidades> lista = new List<ECertificadoUtilidades>();
            lista = obECertificadoUtilidades.Listar_CertificadoUtilidades(anhio, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string CertificadoCts(Int32 post, String dni, String periodo)
        {
            List<ECertificadoCts> lista = new List<ECertificadoCts>();
            lista = obECertificadoCts.Listar_CertificadoCts(post, dni, periodo);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarBoletapago(String periodo)
        {
            List<EListarBoletapago> lista = new List<EListarBoletapago>();
            lista = obEListarBoletapago.Listar_ListarBoletapago(periodo);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarUtilidades(Int32 anhio)
        {
            List<EListarUtilidades> lista = new List<EListarUtilidades>();
            lista = obEListarUtilidades.Listar_ListarUtilidades(anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarCTS(String periodo)
        {
            List<EListarCTS> lista = new List<EListarCTS>();
            lista = obEListarCTS.Listar_ListarCTS(periodo);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarBoletin()
        {
            List<EListarBoletin> lista = new List<EListarBoletin>();
            lista = obEListarBoletin.Listar_ListarBoletin();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarCalendario()
        {
            List<EListarCalendario> lista = new List<EListarCalendario>();
            lista = obEListarCalendario.Listar_ListarCalendario();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string LogBoletas(String dni, String nroboleta, String ip)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantLogBoletas.MantLogBoletas(dni, nroboleta, ip);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string LogUtilidades(String dni, String periodo, String ip)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantLogUtilidades.MantLogUtilidades(dni, periodo, ip);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string LogCTS(String dni, String periodo, String ip)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantLogCTS.MantLogCTS(dni, periodo, ip);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MostrarAlert(string dni)
        {
            List<EListarSweetAlert> lista = new List<EListarSweetAlert>();
            lista = obEListarSweetAlert.Listar_ListarSweetAlert(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MostrarToast(Int32 post, string dni)
        {
            List<EListarToast> lista = new List<EListarToast>();
            lista = obEListarToast.Listar_ListarToast(post, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }


        // WEB2
        [WebMethod]
        public string ListarPais()
        {
            List<EPais> lista = new List<EPais>();
            lista = obEPais.Listar_Pais();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarDepartamento()
        {
            List<EDepartamento> lista = new List<EDepartamento>();
            lista = obEDepartamento.Listar_Departamento();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarProvincia(Int32 departamento)
        {
            List<EProvincia> lista = new List<EProvincia>();
            lista = obEProvincia.Listar_Provincia(departamento);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarDistrito(Int32 provincia)
        {
            List<EDistrito> lista = new List<EDistrito>();
            lista = obEDistrito.Listar_Distrito(provincia);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarCentroCosto()
        {
            List<ECentroCosto> lista = new List<ECentroCosto>();
            lista = obECentroCosto.Listar_CentroCosto();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarCuenta()
        {
            List<ECuenta> lista = new List<ECuenta>();
            lista = obECuenta.Listar_Cuenta();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarEmpresa()
        {
            List<EEmpresa> lista = new List<EEmpresa>();
            lista = obEEmpresa.Listar_Empresa();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarZona(Int32 id, Int32 zona)
        {
            List<EZona> lista = new List<EZona>();
            lista = obEZona.Listar_Zona(id, zona);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarLocal(Int32 id, Int32 zona)
        {
            List<ELocal> lista = new List<ELocal>();
            lista = obELocal.Listar_Local(id, zona);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarTurno(Int32 id, Int32 turno)
        {
            List<ETurno> lista = new List<ETurno>();
            lista = obETurno.Listar_Turno(id, turno);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarTurnoDetalle(Int32 post, Int32 semana, Int32 local, Int32 anhio, String dni)
        {
            List<ETurnoDetalle> lista = new List<ETurnoDetalle>();
            lista = obETurnoDetalle.Listar_TurnoDetalle(post, semana, local, anhio, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarSemana(Int32 post, String user)
        {
            List<ESemana> lista = new List<ESemana>();
            lista = obESemana.Listar_Semana(post, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarPersonal(Int32 post, String dni, Int32 local)
        {
            List<EPersonal> lista = new List<EPersonal>();
            lista = obEPersonal.Listar_Personal(post, dni, local);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarGrupoArea()
        {
            List<EGrupoArea> lista = new List<EGrupoArea>();
            lista = obEGrupoArea.Listar_GrupoArea();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarGrupoCargo()
        {
            List<EGrupoCargo> lista = new List<EGrupoCargo>();
            lista = obEGrupoCargo.Listar_GrupoCargo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarComision(Int32 post, String dni)
        {
            List<EComision> lista = new List<EComision>();
            lista = obEComision.Listar_Comision(post, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantIndicadorPersonal(
            String dni, Int32 zona, Int32 local, Int32 area, Int32 cargo, Int32 turno, Int32 flex, Int32 remoto, Int32 marcacion, Int32 venta, String user )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantIndicadorPersonal.MantIndicadorPersonal(dni, zona, local, area, cargo, turno, flex, remoto, marcacion, venta, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndHeadcount()
        {
            List<EIndHeadcount> lista = new List<EIndHeadcount>();
            lista = obEIndHeadcount.Listar_IndHeadcount();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndDotacion()
        {
            List<EIndDotacion> lista = new List<EIndDotacion>();
            lista = obEIndDotacion.Listar_IndDotacion();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndHeadcountArea()
        {
            List<EIndHeadcountArea> lista = new List<EIndHeadcountArea>();
            lista = obEIndHeadcountArea.Listar_IndHeadcountArea();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndDotacionArea()
        {
            List<EIndDotacionArea> lista = new List<EIndDotacionArea>();
            lista = obEIndDotacionArea.Listar_IndDotacionArea();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndHeadcountCargo()
        {
            List<EIndHeadcountCargo> lista = new List<EIndHeadcountCargo>();
            lista = obEIndHeadcountCargo.Listar_IndHeadcountCargo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndDotacionCargo()
        {
            List<EIndDotacionCargo> lista = new List<EIndDotacionCargo>();
            lista = obEIndDotacionCargo.Listar_IndDotacionCargo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndAusentismo()
        {
            List<EIndAusentismo> lista = new List<EIndAusentismo>();
            lista = obEIndAusentismo.Listar_IndAusentismo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndAusentismorem()
        {
            List<EIndAusentismorem> lista = new List<EIndAusentismorem>();
            lista = obEIndAusentismorem.Listar_IndAusentismorem();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndAusentismonorem()
        {
            List<EIndAusentismonorem> lista = new List<EIndAusentismonorem>();
            lista = obEIndAusentismonorem.Listar_IndAusentismonorem();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndAusentismoxArea()
        {
            List<EIndAusentismoxArea> lista = new List<EIndAusentismoxArea>();
            lista = obEIndAusentismoxArea.Listar_IndAusentismoxArea();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndAusentismoxCargo()
        {
            List<EIndAusentismoxCargo> lista = new List<EIndAusentismoxCargo>();
            lista = obEIndAusentismoxCargo.Listar_IndAusentismoxCargo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndHE()
        {
            List<EIndHE> lista = new List<EIndHE>();
            lista = obEIndHE.Listar_IndHE();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndHESoles()
        {
            List<EIndHESoles> lista = new List<EIndHESoles>();
            lista = obEIndHESoles.Listar_IndHESoles();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndHExPersona()
        {
            List<EIndHExPersona> lista = new List<EIndHExPersona>();
            lista = obEIndHExPersona.Listar_IndHExPersona();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarIndHExMontos()
        {
            List<EIndHExMontos> lista = new List<EIndHExMontos>();
            lista = obEIndHExMontos.Listar_IndHExMontos();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantZona(Int32 id, Int32 zona, String nombre, Int32 estado, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantZona.MantZona(id, zona, nombre, estado, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantLocal(Int32 id, Int32 local, String nombre, Int32 zona, Int32 estado, String abrev, String user, String hinicio, String hfin, String htolerancia, Int32 tipoasistencia)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantLocal.MantLocal(id, local, nombre, zona, estado, abrev, user, hinicio, hfin, htolerancia, tipoasistencia);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantTurno(Int32 id, Int32 semana,  Int32 local, Int32 anhio, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantTurno.MantTurno(id, semana, local, anhio, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantTurnoDetalle(Int32 post, String dni, String dia, Int32 semana, Int32 anhio, String horainicio, String horafin, String tolerancia, Int32 local, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantTurnoDetalle.MantTurnoDetalle(post, dni, dia, semana, anhio, horainicio, horafin, tolerancia, local, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string SolicitudComision(String dni, String fecha, String horainicio, String horafin, String asunto, String fundamentacion, Int32 tipocomision)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obESolicitudComision.SolicitudComision(dni, fecha, horainicio, horafin, asunto, fundamentacion, tipocomision);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ConPerfiles(Int32 post, Int32 perfil)
        {
            List<EConPerfiles> lista = new List<EConPerfiles>();
            lista = obEConPerfiles.ConPerfiles(post, perfil);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ConPerfilesAccesos(Int32 post, Int32 perfil, Int32 menu)
        {
            List<EConPerfilesAccesos> lista = new List<EConPerfilesAccesos>();
            lista = obEConPerfilesAccesos.ConPerfilesAccesos(post, perfil, menu);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantPerfilesAccesos(Int32 post, Int32 menu, Int32 submenu, Int32 perfil, Int32 tipo, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantPerfilesAccesos.MantPerfilesAccesos(post, menu, submenu, perfil, tipo, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantPerfiles(Int32 post, String nombre, Int32 estado, Int32 perfil, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantPerfiles.MantPerfiles(post, nombre, estado, perfil, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarUsuarios(Int32 post, String dni, Int32 estado)
        {
            List<EListarUsuarios> lista = new List<EListarUsuarios>();
            lista = obEListarUsuarios.Listar_ListarUsuarios(post, dni, estado);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantUsuarios(Int32 post, String dni, Int32 estado, Int32 perfil, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantUsuario.MantUsuario(post, dni, estado, perfil, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarJefes()
        {
            List<EListarJefes> lista = new List<EListarJefes>();
            lista = obEListarJefes.Listar_ListarJefes();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarAsistentes(String dni)
        {
            List<EListarAsistentes> lista = new List<EListarAsistentes>();
            lista = obEListarAsistentes.Listar_ListarAsistentes(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantJefeAsistente(Int32 post, String dnijefe, String dniasistente, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantJefeAsistente.MantJefeAsistente(post, dnijefe, dniasistente, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string PeriodosBoletas()
        {
            List<EPeriodosBoletas> lista = new List<EPeriodosBoletas>();
            lista = obEPeriodosBoletas.PeriodosBoletas();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantPeriodosBoletas(Int32 post, Int32 id, String periodo, Int32 estado, String firma, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantPeriodosBoletas.MantPeriodosBoletas(post, id, periodo, estado, firma, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantenimientoUserPassword(String dni, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantUserPassword.MantUserPassword(dni, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ActualizacionDatos(String dni)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEActualizacionDatos.ActualizacionDatos(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }


        [WebMethod]
        public string ConsultaFinalistas()
        {
            List<EConsultaFinalistas> lista = new List<EConsultaFinalistas>();
            lista = obEConsultaFinalistas.ConsultaFinalistas();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ConsultaPaPersonal(String dni, String publicacion)
        {
            List<EConsultaPaPersonal> lista = new List<EConsultaPaPersonal>();
            lista = obEConsultaPaPersonal.ConsultaPaPersonal(dni, publicacion);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantRegPersonal(
            String pertipodoc,
            String perpaterno,
            String permaterno,
            String pernombre,
            String peremail,
            String peressalud,
            String perdomic,
            String perrefzona,
            String perdep,
            String perprov,
            String perdist,
            String perttrab,
            String perregimen,
            String pernivel,
            String perocup,
            String perdisc,
            String pertcon,
            String perjmax,
            String perafeps,
            String perexqta,
            String pertpago,
            String perafp,
            String perarea,
            String perbanco,
            String perbancocts,
            String perbruto,
            String percargo,
            String percond,
            String perctaban,
            String perdir,
            String perid,
            String peremp,
            String perfing,
            String perfnac,
            Int32 perhijos,
            String permovilidad,
            String pernac,
            String pernumafp,
            String perruc,
            String perruta,
            String perseguro,
            String persub,
            String persubarea,
            String persexo,
            String pertipopago,
            String pertlf1,
            String perzonaid,
            String user10,
            String user2,
            String user4,
            String user5,
            String user6,
            String MontoQuintaExt,
            String MontoRetenidoQuinta,
            String movilidadAdmin,
            String periodosueldo,
            String periodoqta,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantRegPersonal.MantRegPersonal(
                    pertipodoc, perpaterno, permaterno, pernombre, peremail, peressalud,
                    perdomic, perrefzona, perdep, perprov, perdist, perttrab, perregimen,
                    pernivel, perocup, perdisc, pertcon, perjmax, perafeps, perexqta,
                    pertpago, perafp, perarea, perbanco, perbancocts, perbruto, percargo,
                    percond, perctaban, perdir, perid, peremp, perfing, perfnac,
                    perhijos, permovilidad, pernac, pernumafp, perruc, perruta, perseguro,
                    persub, persubarea, persexo, pertipopago, pertlf1, perzonaid, user10,
                    user2, user4, user5, user6, MontoQuintaExt, MontoRetenidoQuinta, movilidadAdmin,
                    periodosueldo, periodoqta, user
                );
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoEvaluacion(String dni)
        {
            List<EEvaluacionPersona> lista = new List<EEvaluacionPersona>();
            lista = obEvaluacionPersona.ListadoEvaluacion(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListadoEvaluacionPdf(String v_dni, Int32 i_anhio)
        {
            List<EEvaluacionPersonaPdf> lista = new List<EEvaluacionPersonaPdf>();
            lista = obEvaluacionPersona.ListadoEvaluacionPdf(v_dni, i_anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarConvenios(Int32 post, Int32 id)
        {
            List<EListarConvenios> lista = new List<EListarConvenios>();
            lista = obEListarConvenios.ListarConvenios(post, id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarConveniosEducativos(Int32 post, Int32 id)
        {
            List<EListarConveniosEducativos> lista = new List<EListarConveniosEducativos>();
            lista = obEListarConveniosEducativos.ListarConveniosEducativos(post, id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantConvenios(
            Int32 post, 
            Int32 id,
            Int32 condicion, 
            String nombre, 
            Int32 estado, 
            String finicio, 
            String ffin, 
            String tarjeta, 
            String ventana,
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantConvenios.MantConvenios(post, id, condicion, nombre, estado, finicio, ffin, tarjeta, ventana, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarConveniosTexto(Int32 id)
        {
            List<EListarConveniosTexto> lista = new List<EListarConveniosTexto>();
            lista = obEListarConveniosTexto.ListarConveniosTexto(id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarDisenioTexto(Int32 id)
        {
            List<EListarDisenioTexto> lista = new List<EListarDisenioTexto>();
            lista = obEListarDisenioTexto.ListarDisenioTexto(id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantConveniosTexto(
            Int32 post,
            Int32 id,
            Int32 iconvenio,
            String texto,
            Int32 tamanio,
            String color,
            Int32 r,
            Int32 g,
            Int32 b,
            Int32 angulo,
            Int32 posicionx,
            Int32 posiciony,
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantConveniosTexto.MantConveniosTexto(post, id, iconvenio, texto, tamanio, color, r, g, b, angulo, posicionx, posiciony, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantConveniosEducativos(
            Int32 post,
            Int32 id,
            Int32 condicion,
            String nombre,
            Int32 estado,
            String finicio,
            String ffin,
            String tarjeta,
            String ventana,
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantConveniosEducativos.MantConveniosEducativos(post, id, condicion, nombre, estado, finicio, ffin, tarjeta, ventana, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarFlexTime(Int32 id, Int32 idflex, Int32 zona, Int32 local)
        {
            List<EListarFlexTime> lista = new List<EListarFlexTime>();
            lista = obEListarFlexTime.ListarFlexTime(id, idflex, zona, local);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantFlexTime(
            Int32 post,
            Int32 id,
            String nombre, 
            Int32 estado,
            String hinicio, 
            String hfin, 
            String htolerancia,
            Int32 zona,
            Int32 local,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantFlexTime.MantFlexTime(post, id, nombre, estado, hinicio, hfin, htolerancia, zona, local, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string TablaFlexTime(Int32 post, String user, Int32 anhio, Int32 mes)
        {
            List<ETablaFlexTime> lista = new List<ETablaFlexTime>();
            lista = obETablaFlexTime.TablaFlexTime(post, user, anhio, mes);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantTablaFlexTime(
            Int32 post,
            Int32 id,
            Int32 semana,
            Int32 flex,
            Int32 zona,
            Int32 local,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantTablaFlexTime.MantTablaFlexTime(post, id, semana, flex, zona, local, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ControlFlexTime(String dnijefe, Int32 anhio, Int32 mes)
        {
            List<EControlFlexTime> lista = new List<EControlFlexTime>();
            lista = obEControlFlexTime.ControlFlexTime(dnijefe, anhio, mes);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantControlFlexTime(
            Int32 post,
            Int32 id,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantControlFlexTime.MantControlFlexTime(post, id, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string TablaRemoto(Int32 post, String user, Int32 anhio)
        {
            List<ETablaRemoto> lista = new List<ETablaRemoto>();
            lista = obETablaRemoto.TablaRemoto(post, user, anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantTablaRemoto(
            Int32 post,
            Int32 id,
            Int32 semana,
            Int32 zona,
            Int32 local,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantTablaRemoto.MantTablaRemoto(post, id, semana, zona, local, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ControlRemoto(String dnijefe, Int32 anhio, Int32 mes)
        {
            List<EControlRemoto> lista = new List<EControlRemoto>();
            lista = obEControlRemoto.ControlRemoto(dnijefe, anhio, mes);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantControlRemoto(
            Int32 post,
            Int32 id,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantControlRemoto.MantControlRemoto(post, id, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarFeriado(Int32 post, Int32 id, Int32 anhio)
        {
            List<EListarFeriado> lista = new List<EListarFeriado>();
            lista = obEListarFeriado.ListarFeriado(post, id, anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantFeriado(
            Int32 post,
            Int32 id,
            String descripcion,
            String fferiado,
            Int32 estado,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantFeriado.MantFeriado(post, id, descripcion, fferiado, estado, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string GetMarcacion(String dni)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEGetMarcacion.GetMarcacion(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantMensajeMarcacion(String dni)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantMensajeMarcacion.MantMensajeMarcacion(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantMarcacion(String dni, String comentario, Int32 marcahuella, Int32 marcadni, String temperatura, String remoto)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantMarcacion.MantMarcacion(dni, comentario, marcahuella, marcadni, temperatura, remoto);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listarcumpleaniosxdni(String dni)
        {
            List<EListarcumpleaniosxdni> lista = new List<EListarcumpleaniosxdni>();
            lista = obEListarcumpleaniosxdni.Listarcumpleaniosxdni(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantVacacioncumpleanios(
            Int32 post,
            Int32 id,
            String fecha,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantVacacioncumpleanios.MantVacacioncumpleanios(post, id, fecha, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listadovacacionescumplejefe(String dni, String finicio, String ffin)
        {
            List<EListadovacacionescumplejefe> lista = new List<EListadovacacionescumplejefe>();
            lista = obEListadovacacionescumplejefe.Listadovacacionescumplejefe(dni, finicio, ffin);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarInventario(Int32 post, String sku)
        {
            List<EListarInventario> lista = new List<EListarInventario>();
            lista = obEListarInventario.ListarInventario(post, sku);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string GetInventario()
        {
            List<EGetInventario> lista = new List<EGetInventario>();
            lista = obEGetInventario.GetInventario();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantInventario(
            Int32 post,
            String sku,
            Int32 estado,
            String user
            )
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantInventario.MantInventario(post, sku, estado, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ConfiguracionCorreo()
        {
            List<EConfiguracionCorreo> lista = new List<EConfiguracionCorreo>();
            lista = obEConfiguracionCorreo.ConfiguracionCorreo();
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantLogCorreos(Int32 post, String ticket, String para, String copia, String asunto, String mensaje, Int32 output, String ruta, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantLogCorreos.MantLogCorreos(post, ticket, para, copia, asunto, mensaje, output, ruta, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantVentaCabecera(Int32 post, Int32 id, String ticket, String para, String copia, String asunto, String subtotal, String igv, String total, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantVentaCabecera.MantVentaCabecera(post, id, ticket, para, copia, asunto, subtotal, igv, total, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantVentaDetalle(Int32 post, String pedido, String sku, String precio, String cantidad, String subtotal, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantVentaDetalle.MantVentaDetalle(post, pedido, sku, precio, cantidad, subtotal, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarTopeVentas(String dni)
        {
            List<EListarTopeVentas> lista = new List<EListarTopeVentas>();
            lista = obEListarTopeVentas.ListarTopeVentas(dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarNotificaciones(Int32 post, Int32 id)
        {
            List<EListarNotificaciones> lista = new List<EListarNotificaciones>();
            lista = obEListarNotificaciones.ListarNotificaciones(post, id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantNotificaciones(
            Int32 post, 
            Int32 id, 
            String clase, 
            String titulo, 
            String cuerpo, 
            String descripcion,
            String modulo,
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantNotificaciones.MantNotificaciones(post, id, clase, titulo, cuerpo, descripcion, modulo, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarPaNotificaciones(Int32 post, Int32 top, String dni)
        {
            List<EListarPaNotificaciones> lista = new List<EListarPaNotificaciones>();
            lista = obEListarPaNotificaciones.ListarPaNotificaciones(post, top, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantNotificacionesPersonal(
            Int32 post,
            Int32 id,
            String dni)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantNotificacionesPersonal.MantNotificacionesPersonal(post, id, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarBuzonsugerencia(Int32 post)
        {
            List<EListarBuzonsugerencia> lista = new List<EListarBuzonsugerencia>();
            lista = obEListarBuzonsugerencia.ListarBuzonsugerencia(post);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantLogCorreosBuzonsugerencia(
            Int32 post,
            String ticket,
            String para, 
            String copia, 
            Int32 asunto,
            String desc_asunto,
            String mensaje, 
            Int32 output, 
            String ruta, 
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantLogCorreosBuzonsugerencia.MantLogCorreosBuzonsugerencia(post, ticket, para, copia, asunto, desc_asunto, mensaje, output, ruta, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarCorreoBuzonsugerencia(Int32 post, String dni)
        {
            List<EListarCorreoBuzonsugerencia> lista = new List<EListarCorreoBuzonsugerencia>();
            lista = obEListarCorreoBuzonsugerencia.ListarCorreoBuzonsugerencia(post, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarTipoArchivos(Int32 post, Int32 id, String mime, String type)
        {
            List<EListarTipoArchivos> lista = new List<EListarTipoArchivos>();
            lista = obEListarTipoArchivos.ListarTipoArchivos(post, id, mime, type);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantArchivos(
            Int32 post,
            Int32 id,
            String nombre,
            String mime,
            String type,
            String icono,
            String color,
            String dni)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantArchivos.MantArchivos(post, id, nombre, mime, type, icono, color, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantArchivosLegajo(
            Int32 post,
            Int32 id,
            String nombre,
            String carpeta,
            String modulo,
            Int32 estado,
            Int32 cantidad,
            String tipoarchivo,
            String tamanio,
            String dni)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantArchivosLegajo.MantArchivosLegajo(post, id, nombre, carpeta, modulo, estado, cantidad, tipoarchivo, tamanio, dni);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantLogCorreosCanaldenuncia(
            Int32 post,
            String ticket,
            String para,
            String copia,
            Int32 anonimo,
            String asunto,
            String archivo,
            String mensaje,
            Int32 output,
            String ruta,
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantLogCorreosCanaldenuncia.MantLogCorreosCanaldenuncia(post, ticket, para, copia, anonimo, asunto, archivo, mensaje, output, ruta, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarNotificumpleanios(Int32 post, Int32 id)
        {
            List<EListarNotificumpleanios> lista = new List<EListarNotificumpleanios>();
            lista = obEListarNotificumpleanios.ListarNotificumpleanios(post, id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantNotificumpleanios(
            Int32 post,
            Int32 id,
            Int32 condicion,
            String nombre,
            Int32 estado,
            String ventana,
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantNotificumpleanios.MantNotificumpleanios(post, id, condicion, nombre, estado, ventana, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarNotificumpleTexto(Int32 id)
        {
            List<EListarNotificumpleTexto> lista = new List<EListarNotificumpleTexto>();
            lista = obEListarNotificumpleTexto.ListarNotificumpleTexto(id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListarDisenioNotificumpleTexto(Int32 id)
        {
            List<EListarDisenioNotificumpleTexto> lista = new List<EListarDisenioNotificumpleTexto>();
            lista = obEListarDisenioNotificumpleTexto.ListarDisenioNotificumpleTexto(id);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantNotificumpleaniosTexto(
            Int32 post,
            Int32 id,
            Int32 icumple,
            String texto,
            Int32 tamanio,
            String color,
            Int32 r,
            Int32 g,
            Int32 b,
            Int32 angulo,
            Int32 posicionx,
            Int32 posiciony,
            Int32 alineacion,
            String fuente,
            String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantNotificumpleaniosTexto.MantNotificumpleaniosTexto(post, id, icumple, texto, tamanio, color, r, g, b, angulo, posicionx, posiciony, alineacion, fuente, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }
        

        [WebMethod]
        public string Listarpagovacaciones(Int32 post, Int32 mes, Int32 anhio, String fecha)
        {
            List<EListarpagovacaciones> lista = new List<EListarpagovacaciones>();
            lista = obEListarpagovacaciones.Listarpagovacaciones(post, mes, anhio, fecha);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string MantPagovacaciones(Int32 post, Int32 mes, Int32 anhio, String fecha, Int32 ivac, String user)
        {
            List<EMantenimiento> lista = new List<EMantenimiento>();
            lista = obEMantPagovacaciones.MantPagovacaciones(post, mes, anhio, fecha, ivac, user);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string Listarenviovacaciones(Int32 mes, Int32 anhio)
        {
            List<EListarenviovacaciones> lista = new List<EListarenviovacaciones>();
            lista = obEListarenviovacaciones.Listarenviovacaciones(mes, anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }

        [WebMethod]
        public string ListaReportePagoVacaciones(Int32 mes, Int32 anhio)
        {
            List<EListaReportePagoVacaciones> lista = new List<EListaReportePagoVacaciones>();
            lista = obEListaReportePagoVacaciones.ListaReportePagoVacaciones(mes, anhio);
            string json = JsonConvert.SerializeObject(lista);
            return json;
        }
    }
}