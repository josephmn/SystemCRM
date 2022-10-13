using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VSolicitudvacaciones : BDconexion
    {
        public List<EMantenimiento> Solicitudvacaciones(String dateinicio, String datefin, String dni, Int32 tipovac)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CSolicitudvacaciones oVSolicitudvacaciones = new CSolicitudvacaciones();
                    lCEMantenimiento = oVSolicitudvacaciones.Solicitudvacaciones(con, dateinicio, datefin, dni, tipovac);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}