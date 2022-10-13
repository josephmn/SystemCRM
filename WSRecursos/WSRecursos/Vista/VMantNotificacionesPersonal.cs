using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantNotificacionesPersonal : BDconexion
    {
        public List<EMantenimiento> MantNotificacionesPersonal(Int32 post,
            Int32 id,
            String dni)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantNotificacionesPersonal oVMantNotificacionesPersonal = new CMantNotificacionesPersonal();
                    lCEMantenimiento = oVMantNotificacionesPersonal.MantNotificacionesPersonal(con, post, id, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}