using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantNotificaciones : BDconexion
    {
        public List<EMantenimiento> MantNotificaciones(Int32 post,
            Int32 id,
            String clase,
            String titulo,
            String cuerpo,
            String descripcion,
            String modulo,
            String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantNotificaciones oVMantNotificaciones = new CMantNotificaciones();
                    lCEMantenimiento = oVMantNotificaciones.MantNotificaciones(con, post, id, clase, titulo, cuerpo, descripcion, modulo, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}