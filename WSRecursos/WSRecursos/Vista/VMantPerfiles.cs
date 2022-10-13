using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantPerfiles : BDconexion
    {
        public List<EMantenimiento> MantPerfiles(Int32 post, String nombre, Int32 estado, Int32 perfil, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantPerfiles oVMantPerfiles = new CMantPerfiles();
                    lCEMantenimiento = oVMantPerfiles.MantPerfiles(con, post, nombre, estado, perfil, user);
                }
                catch (SqlException)
                {

                }
            }
            return (lCEMantenimiento);
        }
    }
}