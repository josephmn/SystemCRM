using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VSolicitudComision : BDconexion
    {
        public List<EMantenimiento> SolicitudComision(String dni, String fecha, String horainicio, String horafin, String asunto, String fundamentacion, Int32 tipocomision)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CSolicitudComision oVSolicitudComision = new CSolicitudComision();
                    lCEMantenimiento = oVSolicitudComision.SolicitudComision(con, dni, fecha, horainicio, horafin, asunto, fundamentacion, tipocomision);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}