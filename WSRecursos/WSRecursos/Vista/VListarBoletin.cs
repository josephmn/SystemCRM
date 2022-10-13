using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarBoletin : BDconexion
    {
        public List<EListarBoletin> Listar_ListarBoletin()
        {
            List<EListarBoletin> lCListarBoletin = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarBoletin oVListarBoletin = new CListarBoletin();
                    lCListarBoletin = oVListarBoletin.Listar_ListarBoletin(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarBoletin);
        }
    }
}