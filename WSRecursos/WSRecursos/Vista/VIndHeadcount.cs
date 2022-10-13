using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndHeadcount : BDconexion
    {
        public List<EIndHeadcount> Listar_IndHeadcount()
        {
            List<EIndHeadcount> lCIndHeadcount = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndHeadcount oVIndHeadcount = new CIndHeadcount();
                    lCIndHeadcount = oVIndHeadcount.Listar_IndHeadcount(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndHeadcount);
        }
    }
}