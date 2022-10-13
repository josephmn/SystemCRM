using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarToast : BDconexion
    {
        public List<EListarToast> Listar_ListarToast(Int32 post, String dni)
        {
            List<EListarToast> lCListarToast = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarToast oVListarToast = new CListarToast();
                    lCListarToast = oVListarToast.Listar_ListarToast(con, post, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarToast);
        }
    }
}