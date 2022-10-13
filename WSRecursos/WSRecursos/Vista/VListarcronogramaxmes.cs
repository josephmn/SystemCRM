using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarcronogramaxmes : BDconexion
    {
        public List<EListarcronogramaxmes> Listar_Listarcronogramaxmes(Int32 mes, Int32 anhio)
        {
            List<EListarcronogramaxmes> lCListarcronogramaxmes = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarcronogramaxmes oVListarcronogramaxmes = new CListarcronogramaxmes();
                    lCListarcronogramaxmes = oVListarcronogramaxmes.Listar_Listarcronogramaxmes(con, mes, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarcronogramaxmes);
        }
    }
}