using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantUsuario : BDconexion
    {
        public List<EMantenimiento> MantUsuario(Int32 post, String dni, Int32 estado, Int32 perfil, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantUsuario oVMantUsuario = new CMantUsuario();
                    lCEMantenimiento = oVMantUsuario.MantUsuario(con, post, dni, estado, perfil, user);
                }
                catch (SqlException)
                {

                }
            }
            return (lCEMantenimiento);
        }
    }
}