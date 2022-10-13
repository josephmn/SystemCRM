using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarDisenioTexto : BDconexion
    {
        public List<EListarDisenioTexto> ListarDisenioTexto(Int32 id)
        {
            List<EListarDisenioTexto> lCListarDisenioTexto = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarDisenioTexto oVListarDisenioTexto = new CListarDisenioTexto();
                    lCListarDisenioTexto = oVListarDisenioTexto.ListarDisenioTexto(con, id);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarDisenioTexto);
        }
    }
}