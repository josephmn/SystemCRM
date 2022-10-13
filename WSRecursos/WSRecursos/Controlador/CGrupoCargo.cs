using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CGrupoCargo
    {
        public List<EGrupoCargo> Listar_GrupoCargo(SqlConnection con)
        {
            List<EGrupoCargo> lEGrupoCargo = null;
            SqlCommand cmd = new SqlCommand("ASP_GRUPO_CARGO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEGrupoCargo = new List<EGrupoCargo>();

                EGrupoCargo obEGrupoCargo = null;
                while (drd.Read())
                {
                    obEGrupoCargo = new EGrupoCargo();
                    obEGrupoCargo.i_codigo = drd["i_codigo"].ToString();
                    obEGrupoCargo.v_descripcion = drd["v_descripcion"].ToString();
                    lEGrupoCargo.Add(obEGrupoCargo);
                }
                drd.Close();
            }

            return (lEGrupoCargo);
        }
    }
}