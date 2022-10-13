using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListaReportePagoVacaciones : BDconexion
    {
        public List<EListaReportePagoVacaciones> ListaReportePagoVacaciones(Int32 mes, Int32 anhio)
        {
            List<EListaReportePagoVacaciones> lCListaReportePagoVacaciones = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListaReportePagoVacaciones oVListaReportePagoVacaciones = new CListaReportePagoVacaciones();
                    lCListaReportePagoVacaciones = oVListaReportePagoVacaciones.ListaReportePagoVacaciones(con, mes, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListaReportePagoVacaciones);
        }
    }
}