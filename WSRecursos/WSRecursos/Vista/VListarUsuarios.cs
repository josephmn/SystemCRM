using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarUsuarios : BDconexion
    {
        public List<EListarUsuarios> Listar_ListarUsuarios(Int32 post, String dni, Int32 estado)
        {
            List<EListarUsuarios> lCListarUsuarios = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarUsuarios oVListarUsuarios = new CListarUsuarios();
                    lCListarUsuarios = oVListarUsuarios.Listar_ListarUsuarios(con, post, dni, estado);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarUsuarios);
        }
    }
}