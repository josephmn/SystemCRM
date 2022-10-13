using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantMarcacion : BDconexion
    {
        public List<EMantenimiento> MantMarcacion(String dni, String comentario, Int32 marcahuella, Int32 marcadni, String temperatura, String remoto)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantMarcacion oVMantMarcacion = new CMantMarcacion();
                    lCEMantenimiento = oVMantMarcacion.MantMarcacion(con, dni, comentario, marcahuella, marcadni, temperatura, remoto);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}