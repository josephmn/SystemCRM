using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarFeriado : BDconexion
    {
        public List<EListarFeriado> ListarFeriado(Int32 post, Int32 id, Int32 anhio)
        {
            List<EListarFeriado> lCListarFeriado = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarFeriado oVListarFeriado = new CListarFeriado();
                    lCListarFeriado = oVListarFeriado.ListarFeriado(con, post, id, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarFeriado);
        }
    }
}