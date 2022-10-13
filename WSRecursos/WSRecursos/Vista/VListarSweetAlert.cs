using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarSweetAlert : BDconexion
    {
        public List<EListarSweetAlert> Listar_ListarSweetAlert(String dni)
        {
            List<EListarSweetAlert> lCListarSweetAlert = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarSweetAlert oVListarSweetAlert = new CListarSweetAlert();
                    lCListarSweetAlert = oVListarSweetAlert.Listar_ListarSweetAlert(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarSweetAlert);
        }
    }
}