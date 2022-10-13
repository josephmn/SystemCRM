using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantNotificumpleanios : BDconexion
    {
        public List<EMantenimiento> MantNotificumpleanios(
            Int32 post,
            Int32 id,
            Int32 condicion,
            String nombre,
            Int32 estado,
            String ventana,
            String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantNotificumpleanios oVMantNotificumpleanios = new CMantNotificumpleanios();
                    lCEMantenimiento = oVMantNotificumpleanios.MantNotificumpleanios(con, post, id, condicion, nombre, estado, ventana, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}